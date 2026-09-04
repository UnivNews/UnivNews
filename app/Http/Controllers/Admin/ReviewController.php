<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Mail\ArticleRejected;
use App\Models\Article;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\MayarService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function show(Article $article): View
    {
        $article->load(['user.university', 'category', 'tags']);
        return view('admin.articles.review', compact('article'));
    }

    /**
     * Admin menyetujui artikel:
     *  1. Simpan tanggal publish yang dipilih admin
     *  2. Ubah status artikel ke awaiting_payment
     *  3. Buat invoice di Mayar → simpan ke tabel payments
     *  4. Invoice akan secara otomatis dikirim oleh sistem Mayar
     */
    public function approve(Request $request, Article $article, MayarService $mayar): RedirectResponse
    {
        $validated = $request->validate([
            'publish_date' => 'nullable|date',
            'publish_time' => 'nullable|string',
            'admin_notes'  => 'nullable|string',
        ]);

        // Tentukan jadwal publish
        $publishDate = $validated['publish_date'] ?? date('Y-m-d');
        $publishTime = $validated['publish_time'] ?? '08:00';

        try {
            $publishedAt = Carbon::parse("{$publishDate} {$publishTime}");
        } catch (\Exception $e) {
            $publishedAt = now()->addDay()->setTime(8, 0);
        }

        // Update artikel ke status menunggu pembayaran + simpan jadwal
        $article->update([
            'status'       => Article::STATUS_AWAITING_PAYMENT,
            'published_at' => $publishedAt,
            'admin_notes'  => $validated['admin_notes'] ?? null,
        ]);

        // Ambil nominal dari database settings (fallback ke config/env jika belum ada)
        $amount = Setting::get('publish_fee', config('services.mayar.publish_fee', 25000));

        // Buat invoice di Mayar
        try {
            $invoice = $mayar->createInvoice([
                'name'         => $article->user->name,
                'email'        => $article->user->email,
                'amount'       => $amount,
                'description'  => "Biaya Publish Artikel — {$article->title} (Ref: " . time() . ")",
                'redirect_url' => route('payment.thanks', $article),
            ]);

            $payment = Payment::create([
                'article_id'           => $article->id,
                'author_id'            => $article->user_id,
                'amount'               => $amount,
                'status'               => Payment::STATUS_PENDING,
                'mayar_transaction_id' => $invoice['data']['id'] ?? ($invoice['transaction_id'] ?? null),
                'payment_url'          => $invoice['data']['link'] ?? ($invoice['link'] ?? null),
            ]);

        } catch (\Exception $e) {
            Log::error('Mayar invoice creation failed', [
                'article_id' => $article->id,
                'error'      => $e->getMessage(),
            ]);

            // Rollback artikel ke pending_review agar admin bisa coba lagi
            $article->update(['status' => Article::STATUS_PENDING_REVIEW]);

            return redirect()
                ->route('admin.articles.review', $article)
                ->with('error', 'Gagal membuat invoice pembayaran. Silakan coba lagi. (' . $e->getMessage() . ')');
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' disetujui. Invoice pembayaran telah dibuat (via Mayar).");
    }

    public function reject(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:2000',
        ]);

        $article->update([
            'status'      => Article::STATUS_REJECTED,
            'admin_notes' => $validated['admin_notes'],
        ]);

        // Send rejection notification with revision notes to the article author
        try {
            Mail::to($article->user->email)
                ->send(new ArticleRejected($article->user, $article, $validated['admin_notes']));
        } catch (\Exception $e) {
            Log::warning('Failed to send rejection email', ['article_id' => $article->id, 'error' => $e->getMessage()]);
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel '{$article->title}' ditolak dengan catatan revisi.");
    }
}
