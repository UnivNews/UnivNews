<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Disetujui</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #16a34a; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; }
        .body { padding: 32px; color: #374151; line-height: 1.6; }
        .article-box { background: #f0fdf4; border-left: 4px solid #16a34a; padding: 16px; border-radius: 4px; margin: 20px 0; }
        .article-box h3 { margin: 0 0 4px; color: #15803d; }
        .article-box p { margin: 0; color: #6b7280; font-size: 14px; }
        .btn { display: inline-block; margin-top: 24px; padding: 12px 28px; background: #16a34a; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .footer { background: #f9fafb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Artikel Kamu Disetujui!</h1>
        </div>
        <div class="body">
            <p>Halo, <strong>{{ $author->name }}</strong>!</p>
            <p>Kabar baik! Admin telah mereview dan menyetujui artikel kamu. Artikel kamu kini sudah dipublikasikan di <strong>{{ config('app.name') }}</strong>.</p>

            <div class="article-box">
                <h3>{{ $article->title }}</h3>
                <p>Dipublikasikan: {{ $article->published_at?->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}</p>
            </div>

            @if($article->admin_notes)
            <p><strong>Catatan dari Admin:</strong><br>{{ $article->admin_notes }}</p>
            @endif

            <a href="{{ url('/article/' . $article->slug) }}" class="btn">Lihat Artikel</a>

            <p style="margin-top: 32px;">Terima kasih telah berkontribusi. Terus semangat menulis! 🎉</p>
            <p>Salam,<br><strong>Tim {{ config('app.name') }}</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
