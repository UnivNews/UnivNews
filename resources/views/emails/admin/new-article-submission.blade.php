<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #ffffff; border: 1px solid #e2e8f0; }
        .header { background: #1d4ed8; padding: 24px 40px; }
        .header h1 { color: #ffffff; font-size: 16px; margin: 0; letter-spacing: 1px; }
        .header p { color: #bfdbfe; font-size: 11px; margin: 4px 0 0; }
        .body { padding: 32px 40px; }
        .body p { color: #374151; font-size: 14px; line-height: 1.7; margin: 0 0 14px; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 13px; margin: 20px 0; }
        .data-table td { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; }
        .data-table td:first-child { color: #6b7280; font-weight: 600; width: 35%; background: #f9fafb; }
        .data-table td:last-child { color: #1f2937; }
        .cta-btn { display: inline-block; background: #1d4ed8; color: #ffffff !important; padding: 12px 24px; text-decoration: none; font-weight: bold; font-size: 13px; margin-top: 20px; border-radius: 4px;}
        .footer { padding: 20px 40px; background: #f8f9fa; border-top: 1px solid #e2e8f0; text-align: center; }
        .footer p { color: #94a3b8; font-size: 11px; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>[CMS ADMIN] Artikel Baru Butuh Review</h1>
            <p>Membutuhkan tindakan dari admin</p>
        </div>
        <div class="body">
            <p>Ada artikel baru yang disubmit dan menunggu review:</p>

            <table class="data-table">
                <tr><td>Judul</td><td>{{ $article->title }}</td></tr>
                <tr><td>Author</td><td>{{ $article->user->name }} ({{ $article->user->email }})</td></tr>
                <tr><td>Universitas</td><td>{{ $article->user->university->name ?? '-' }}</td></tr>
                <tr><td>Kategori</td><td>{{ $article->category->name ?? '-' }}</td></tr>
                <tr><td>Tanggal Submit</td><td>{{ now()->format('d M Y, H:i') }}</td></tr>
                <tr><td>Excerpt</td><td>{{ Str::limit($article->excerpt, 200) }}</td></tr>
            </table>

            <a href="{{ route('admin.login') }}" class="cta-btn">
                Masuk ke Panel Admin →
            </a>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh sistem CMS. Hanya untuk internal admin.</p>
            <p style="margin-top: 4px;">© {{ date('Y') }} {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>
