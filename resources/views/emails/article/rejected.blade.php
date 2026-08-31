<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Memerlukan Revisi</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #dc2626; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; }
        .body { padding: 32px; color: #374151; line-height: 1.6; }
        .article-box { background: #fef2f2; border-left: 4px solid #dc2626; padding: 16px; border-radius: 4px; margin: 20px 0; }
        .article-box h3 { margin: 0 0 4px; color: #b91c1c; }
        .article-box p { margin: 0; color: #6b7280; font-size: 14px; }
        .notes-box { background: #fffbeb; border: 1px solid #fbbf24; padding: 16px; border-radius: 4px; margin: 20px 0; }
        .notes-box strong { color: #92400e; }
        .btn { display: inline-block; margin-top: 24px; padding: 12px 28px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .footer { background: #f9fafb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Artikel Memerlukan Revisi</h1>
        </div>
        <div class="body">
            <p>Halo, <strong>{{ $author->name }}</strong>!</p>
            <p>Terima kasih sudah mengirimkan artikel kamu. Setelah melalui proses review, admin memerlukan beberapa revisi sebelum artikel dapat dipublikasikan.</p>

            <div class="article-box">
                <h3>{{ $article->title }}</h3>
                <p>Status: Perlu Revisi</p>
            </div>

            @if($adminNotes)
            <div class="notes-box">
                <strong>📋 Catatan Revisi dari Admin:</strong>
                <p style="margin-top: 8px; color: #374151;">{{ $adminNotes }}</p>
            </div>
            @endif

            <p>Silakan perbaiki artikel kamu sesuai catatan di atas, lalu kirim ulang untuk direview kembali.</p>

            <a href="{{ url('/author/articles') }}" class="btn">Edit Artikel Saya</a>

            <p style="margin-top: 32px;">Jangan menyerah! Revisi adalah bagian dari proses menulis yang baik. 💪</p>
            <p>Salam,<br><strong>Tim {{ config('app.name') }}</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
