<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email dikirim ke author ketika artikelnya berhasil terpublish
 * setelah pembayaran dikonfirmasi via webhook Mayar.
 */
class ArticlePublished extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User    $author,
        public readonly Article $article,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Artikel Kamu Sudah Terpublikasikan! — ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.article.published',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
