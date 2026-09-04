<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman ringkasan pembayaran untuk author.
     * Hanya bisa diakses jika artikel berstatus awaiting_payment
     * dan author adalah pemilik artikel.
     */
    public function show(Article $article): View|RedirectResponse
    {
        $user = auth()->user();

        // Pastikan hanya author pemilik artikel yang bisa akses
        if ($article->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Artikel harus dalam status awaiting_payment
        if (! $article->isAwaitingPayment()) {
            return redirect()->route('author.dashboard')
                ->with('info', 'Artikel ini tidak memerlukan pembayaran saat ini.');
        }

        // Ambil payment record terbaru yang masih pending
        $payment = Payment::where('article_id', $article->id)
            ->where('status', Payment::STATUS_PENDING)
            ->latest()
            ->first();

        if (! $payment) {
            return redirect()->route('author.dashboard')
                ->with('error', 'Data pembayaran tidak ditemukan. Silakan hubungi admin.');
        }

        $article->load(['category', 'user']);

        return view('payment.show', compact('article', 'payment'));
    }

    /**
     * Redirect author ke halaman checkout Mayar.
     */
    public function pay(Request $request, Article $article): RedirectResponse
    {
        $user = auth()->user();

        if ($article->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if (! $article->isAwaitingPayment()) {
            return redirect()->route('author.dashboard')
                ->with('info', 'Artikel ini tidak memerlukan pembayaran saat ini.');
        }

        $payment = Payment::where('article_id', $article->id)
            ->where('status', Payment::STATUS_PENDING)
            ->latest()
            ->first();

        if (! $payment || ! $payment->payment_url) {
            return redirect()->route('payment.show', $article)
                ->with('error', 'Link pembayaran tidak tersedia. Silakan hubungi admin.');
        }

        return redirect($payment->payment_url);
    }

    /**
     * Halaman "terima kasih" — redirect balik dari Mayar setelah pembayaran.
     * Hanya tampilan informasi, bukan trigger publish.
     * Publish artikel sepenuhnya dikendalikan oleh webhook.
     */
    public function thanks(Article $article): View
    {
        $article->load(['user', 'category']);

        return view('payment.thanks', compact('article'));
    }
}
