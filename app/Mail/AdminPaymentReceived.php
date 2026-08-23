<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email notifikasi ke admin bahwa pembayaran berhasil diterima
 * dan artikel sudah otomatis terpublish.
 */
class AdminPaymentReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Article $article,
        public readonly Payment $payment,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💰 Pembayaran Diterima — Artikel "' . $this->article->title . '" Terpublish',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.payment-received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
