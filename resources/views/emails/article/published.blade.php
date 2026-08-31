<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Berhasil Terpublikasikan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Georgia', serif; background: #f0f2f5; margin: 0; padding: 24px 0; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .container { background: #ffffff; border-radius: 2px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.10); }

        .header { background: #00081e; padding: 36px 40px; text-align: center; border-bottom: 4px solid #16a34a; }
        .header-logo { display: inline-flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .logo-box { width: 40px; height: 40px; background: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; color: #fff; font-family: Arial, sans-serif; }
        .logo-text { color: #ffffff; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: bold; line-height: 1.4; }
        .header-sub { color: #7687B2; font-size: 13px; margin-top: 8px; font-family: Arial, sans-serif; }

        .badge-wrap { background: #f0fdf4; border-top: 3px solid #16a34a; padding: 14px 40px; text-align: center; }
        .badge { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: bold; color: #15803d; font-family: Arial, sans-serif; }

        .body { padding: 36px 40px; color: #374151; line-height: 1.7; }
        .greeting { font-size: 16px; margin-bottom: 16px; font-family: Arial, sans-serif; }
        .greeting strong { color: #00081e; }
        .intro { font-size: 14px; color: #4b5563; margin-bottom: 24px; font-family: Arial, sans-serif; }

        .article-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #16a34a; padding: 20px 24px; margin: 0 0 24px; border-radius: 2px; }
        .article-label { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; color: #9ca3af; font-family: Arial, sans-serif; margin-bottom: 6px; }
        .article-title { font-size: 16px; font-weight: bold; color: #00081e; margin-bottom: 10px; line-height: 1.4; }
        .pub-date { font-size: 13px; color: #16a34a; font-family: Arial, sans-serif; font-weight: bold; }

        .cta-wrap { text-align: center; margin: 0 0 28px; }
        .btn { display: inline-block; padding: 16px 48px; background: #16a34a; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; border-radius: 2px; font-family: Arial, sans-serif; }

        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }
        .sign-off { font-size: 14px; color: #4b5563; font-family: Arial, sans-serif; }
        .sign-off strong { color: #00081e; }

        .footer { background: #f8f9fa; border-top: 1px solid #e5e7eb; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 11px; color: #9ca3af; font-family: Arial, sans-serif; line-height: 1.7; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">

            <div class="header">
                <div class="header-logo">
                    <div class="logo-box">U</div>
                    <div class="logo-text">University<span style="font-weight:normal;">News</span></div>
                </div>
                <h1>🎉 Artikel Kamu Sudah Terpublikasikan!</h1>
                <p class="header-sub">Pembayaran berhasil dikonfirmasi</p>
            </div>

            <div class="badge-wrap">
                <span class="badge">✅ &nbsp;Artikel Live</span>
            </div>

            <div class="body">
                <p class="greeting">Halo, <strong>{{ $author->name }}</strong>!</p>
                <p class="intro">
                    Kabar gembira! Pembayaran kamu telah berhasil dikonfirmasi dan artikel kamu kini sudah terpublikasikan di <strong>{{ config('app.name') }}</strong>. Artikel kamu bisa dibaca oleh seluruh komunitas akademik!
                </p>

                <div class="article-box">
                    <div class="article-label">Artikel yang diterbitkan</div>
                    <div class="article-title">{{ $article->title }}</div>
                    <div class="pub-date">
                        📅 Dipublikasikan: {{ $article->published_at ? $article->published_at->locale('id')->isoFormat('dddd, D MMMM YYYY · HH:mm') : now()->locale('id')->isoFormat('dddd, D MMMM YYYY · HH:mm') }} WIB
                    </div>
                </div>

                <div class="cta-wrap">
                    <a href="{{ url('/article/' . $article->slug) }}" class="btn">Lihat Artikel</a>
                </div>

                <p style="font-size:14px;color:#4b5563;margin-bottom:24px;font-family:Arial,sans-serif;text-align:center;">
                    Bagikan artikel kamu ke rekan-rekan dan komunitas akademik! 🚀
                </p>

                <hr class="divider">

                <p class="sign-off">
                    Terima kasih atas kontribusi kamu. Terus semangat menulis! ✍️<br><br>
                    Salam,<br>
                    <strong>Tim {{ config('app.name') }}</strong>
                </p>
            </div>

            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                    Email ini dikirim sebagai konfirmasi publikasi artikel kamu.
                </p>
            </div>

        </div>
    </div>
</body>
</html>
