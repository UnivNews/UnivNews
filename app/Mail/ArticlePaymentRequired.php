<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email dikirim ke author setelah artikel di-approve oleh admin.
 * Berisi informasi artikel, tanggal publish yang telah dijadwalkan,
 * dan link pembayaran untuk melunasi biaya publish.
 */
class ArticlePaymentRequired extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User    $author,
        public readonly Article $article,
        public readonly Payment $payment,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💳 Selesaikan Pembayaran untuk Mempublikasikan Artikel Kamu — ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.article.payment-required',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
