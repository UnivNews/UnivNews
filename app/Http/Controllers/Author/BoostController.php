<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Boost;
use App\Models\BoostPayment;
use App\Models\BoostPrice;
use App\Services\BoostAvailabilityService;
use App\Services\MayarService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BoostController extends Controller
{
    /**
     * Tampilkan halaman form boost artikel
     */
    public function create(Article $article, BoostAvailabilityService $availabilityService)
    {
        $user = auth()->user();

        if ($article->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if (!$article->isPublished()) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Hanya artikel yang sudah dipublish yang bisa di-boost.');
        }

        $boostPrices = BoostPrice::where('is_active', true)->get();
        
        return view('author.articles.boost', compact('article', 'boostPrices'));
    }

    /**
     * Endpoint API untuk mengecek availability kalender
     */
    public function availability(Request $request, Article $article, BoostAvailabilityService $availabilityService)
    {
        $user = auth()->user();
        if ($article->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $startDateStr = $request->query('start_date', now()->toDateString());
        $durationType = $request->query('duration_type', '3_days');
        
        $priceOption = BoostPrice::where('duration_type', $durationType)->first();
        if (!$priceOption) {
            return response()->json(['message' => 'Invalid duration_type'], 422);
        }

        try {
            $startDate = Carbon::parse($startDateStr);
        } catch (\Exception $e) {
            $startDate = now();
        }

        $calendar = $availabilityService->generateCalendar($startDate, 60, $priceOption->duration_days);

        return response()->json([
            'calendar' => $calendar,
        ]);
    }

    /**
     * Buat reservasi boost dan redirect ke pembayaran
     */
    public function store(Request $request, Article $article, BoostAvailabilityService $availabilityService, MayarService $mayar)
    {
        $user = auth()->user();

        if ($article->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if (!$article->isPublished()) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Hanya artikel yang sudah dipublish yang bisa di-boost.');
        }

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'duration_type' => 'required|string|exists:boost_prices,duration_type',
        ]);

        $priceOption = BoostPrice::where('duration_type', $validated['duration_type'])
            ->where('is_active', true)
            ->firstOrFail();

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addDays($priceOption->duration_days - 1); // e.g. 3 days: start 1, end 3. 

        DB::beginTransaction();

        try {
            // Hard check availability
            if (!$availabilityService->isRangeAvailable($startDate, $endDate)) {
                throw new \Exception('Tanggal yang dipilih sudah penuh (maksimal 5 artikel). Silakan pilih tanggal lain.');
            }

            // Create Boost row
            $boost = Boost::create([
                'article_id' => $article->id,
                'user_id' => $user->id,
                'boost_price_id' => $priceOption->id,
                'duration_type' => $priceOption->duration_type,
                'duration_days' => $priceOption->duration_days,
                'price_paid' => $priceOption->price,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'status' => 'pending_payment',
            ]);

            // Create Mayar Invoice
            $invoice = $mayar->createInvoice([
                'name' => $user->name,
                'email' => $user->email,
                'amount' => $priceOption->price,
                'description' => "Boost Artikel '{$article->title}' untuk {$priceOption->duration_days} hari (Ref: " . time() . ")",
                'redirect_url' => route('author.articles.index'), // Just redirect back to dashboard
            ]);

            BoostPayment::create([
                'boost_id' => $boost->id,
                'user_id' => $user->id,
                'amount' => $priceOption->price,
                'status' => 'pending',
                'mayar_transaction_id' => $invoice['data']['id'] ?? ($invoice['transaction_id'] ?? null),
            ]);

            DB::commit();

            $paymentUrl = $invoice['data']['link'] ?? ($invoice['link'] ?? null);
            
            if (!$paymentUrl) {
                throw new \Exception('Tidak bisa mendapatkan link pembayaran.');
            }

            return redirect($paymentUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Boost creation failed', [
                'article_id' => $article->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
