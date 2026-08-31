<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pembayaran Diterima</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 24px 0; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .container { background: #ffffff; border-radius: 2px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.10); }

        .header { background: #00081e; padding: 28px 40px; text-align: center; border-bottom: 4px solid #8b1528; }
        .header h1 { color: #ffffff; font-size: 20px; font-weight: bold; }
        .header-sub { color: #7687B2; font-size: 12px; margin-top: 6px; }

        .badge-wrap { background: #fef9e7; border-top: 3px solid #f59e0b; padding: 12px 40px; text-align: center; }
        .badge { font-size: 13px; font-weight: bold; color: #92400e; }

        .body { padding: 32px 40px; color: #374151; line-height: 1.7; }
        .intro { font-size: 14px; margin-bottom: 24px; }

        .info-grid { display: table; width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; width: 40%; padding: 10px 12px; background: #f8f9fa; border: 1px solid #e5e7eb; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; vertical-align: top; }
        .info-value { display: table-cell; padding: 10px 12px; border: 1px solid #e5e7eb; font-size: 13px; color: #111827; vertical-align: top; }

        .amount-box { background: #00081e; color: #fff; padding: 20px; text-align: center; margin-bottom: 24px; }
        .amount-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #7687B2; margin-bottom: 6px; }
        .amount-value { font-size: 32px; font-weight: bold; }
        .amount-note { font-size: 12px; color: #7687B2; margin-top: 4px; }

        .btn-wrap { text-align: center; margin-bottom: 24px; }
        .btn { display: inline-block; padding: 12px 36px; background: #8b1528; color: #fff; text-decoration: none; font-size: 13px; font-weight: bold; letter-spacing: 0.8px; text-transform: uppercase; border-radius: 2px; }

        .footer { background: #f8f9fa; border-top: 1px solid #e5e7eb; padding: 16px 40px; text-align: center; }
        .footer p { font-size: 11px; color: #9ca3af; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">

            <div class="header">
                <h1>💰 Pembayaran Diterima</h1>
                <p class="header-sub">Notifikasi Admin — {{ config('app.name') }}</p>
            </div>

            <div class="badge-wrap">
                <span class="badge">✅ &nbsp;Artikel Otomatis Terpublish</span>
            </div>

            <div class="body">
                <p class="intro">
                    Pembayaran biaya publish telah berhasil dikonfirmasi oleh sistem. Artikel berikut telah otomatis terpublish sesuai jadwal yang sudah ditentukan.
                </p>

                <!-- Article info table -->
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Judul Artikel</div>
                        <div class="info-value"><strong>{{ $article->title }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Author</div>
                        <div class="info-value">{{ $article->user->name ?? '-' }} ({{ $article->user->email ?? '-' }})</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kategori</div>
                        <div class="info-value">{{ $article->category->name ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Jadwal Publish</div>
                        <div class="info-value">{{ $article->published_at ? $article->published_at->format('d M Y, H:i') . ' WIB' : '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Waktu Bayar</div>
                        <div class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') . ' WIB' : now()->format('d M Y, H:i') . ' WIB' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Transaction ID</div>
                        <div class="info-value" style="font-family:monospace;font-size:12px;">{{ $payment->mayar_transaction_id ?? '-' }}</div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="amount-box">
                    <div class="amount-label">Jumlah Diterima</div>
                    <div class="amount-value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    <div class="amount-note">via Mayar.id</div>
                </div>

                <!-- View article link -->
                <div class="btn-wrap">
                    <a href="{{ url('/article/' . $article->slug) }}" class="btn">Lihat Artikel</a>
                </div>

                <p style="font-size:13px;color:#6b7280;text-align:center;">
                    Tidak diperlukan tindakan lebih lanjut. Artikel telah terpublish secara otomatis.
                </p>
            </div>

            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} {{ config('app.name') }} — Notifikasi Admin.<br>
                    Email ini hanya dikirim ke akun admin terdaftar.
                </p>
            </div>

        </div>
    </div>
</body>
</html>
