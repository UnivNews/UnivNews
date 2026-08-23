<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran Artikel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Georgia', serif; background: #f0f2f5; margin: 0; padding: 24px 0; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .container { background: #ffffff; border-radius: 2px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.10); }

        /* Header */
        .header { background: #00081e; padding: 36px 40px; text-align: center; border-bottom: 4px solid #8b1528; }
        .header-logo { display: inline-flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .logo-box { width: 40px; height: 40px; background: #8b1528; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; color: #fff; font-family: 'Georgia', serif; }
        .logo-text { color: #ffffff; font-size: 20px; font-weight: bold; letter-spacing: 0.5px; font-family: Arial, sans-serif; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: bold; letter-spacing: 0.3px; line-height: 1.4; }
        .header-sub { color: #7687B2; font-size: 13px; margin-top: 8px; font-family: Arial, sans-serif; }

        /* Badge */
        .badge-wrap { background: #fef9e7; border-top: 3px solid #f59e0b; padding: 14px 40px; text-align: center; }
        .badge { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: bold; color: #92400e; font-family: Arial, sans-serif; }

        /* Body */
        .body { padding: 36px 40px; color: #374151; line-height: 1.7; }
        .greeting { font-size: 16px; margin-bottom: 16px; font-family: Arial, sans-serif; }
        .greeting strong { color: #00081e; }
        .intro { font-size: 14px; color: #4b5563; margin-bottom: 24px; font-family: Arial, sans-serif; line-height: 1.7; }

        /* Article Info Box */
        .article-box { background: #f8f9fa; border: 1px solid #e5e7eb; border-left: 4px solid #8b1528; padding: 20px 24px; margin: 0 0 24px; border-radius: 2px; }
        .article-label { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; color: #9ca3af; font-family: Arial, sans-serif; margin-bottom: 6px; }
        .article-title { font-size: 16px; font-weight: bold; color: #00081e; margin-bottom: 12px; line-height: 1.4; }
        .article-meta { display: flex; gap: 8px; flex-wrap: wrap; }
        .meta-chip { display: inline-block; background: #e5e7eb; color: #374151; font-size: 11px; padding: 3px 10px; border-radius: 2px; font-family: Arial, sans-serif; }

        /* Schedule Box */
        .schedule-box { background: #eff6ff; border: 1px solid #bfdbfe; padding: 16px 20px; margin: 0 0 24px; border-radius: 2px; }
        .schedule-box .sch-label { font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #3b82f6; font-family: Arial, sans-serif; margin-bottom: 4px; }
        .schedule-box .sch-date { font-size: 15px; font-weight: bold; color: #1e40af; font-family: Arial, sans-serif; }
        .schedule-box .sch-note { font-size: 12px; color: #6b7280; margin-top: 4px; font-family: Arial, sans-serif; }

        /* Payment Box */
        .payment-box { background: #00081e; color: #fff; padding: 24px; margin: 0 0 28px; border-radius: 2px; text-align: center; }
        .payment-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #7687B2; font-family: Arial, sans-serif; margin-bottom: 8px; }
        .payment-amount { font-size: 36px; font-weight: bold; color: #ffffff; font-family: Arial, sans-serif; letter-spacing: -0.5px; }
        .payment-note { font-size: 12px; color: #7687B2; margin-top: 6px; font-family: Arial, sans-serif; }

        /* CTA Button */
        .cta-wrap { text-align: center; margin: 0 0 28px; }
        .btn { display: inline-block; padding: 16px 48px; background: #8b1528; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; border-radius: 2px; font-family: Arial, sans-serif; }

        /* Steps */
        .steps-title { font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #374151; margin-bottom: 14px; font-family: Arial, sans-serif; }
        .step { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
        .step-num { width: 24px; height: 24px; background: #8b1528; color: #fff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; flex-shrink: 0; font-family: Arial, sans-serif; }
        .step-text { font-size: 13px; color: #4b5563; padding-top: 2px; font-family: Arial, sans-serif; }

        /* Warning */
        .warning { background: #fff7ed; border: 1px solid #fed7aa; padding: 14px 18px; margin: 24px 0 0; border-radius: 2px; }
        .warning p { font-size: 12px; color: #9a3412; font-family: Arial, sans-serif; line-height: 1.6; }

        /* Divider */
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 28px 0; }

        /* Sign off */
        .sign-off { font-size: 14px; color: #4b5563; font-family: Arial, sans-serif; }
        .sign-off strong { color: #00081e; }

        /* Footer */
        .footer { background: #f8f9fa; border-top: 1px solid #e5e7eb; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 11px; color: #9ca3af; font-family: Arial, sans-serif; line-height: 1.7; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">

            <!-- Header -->
            <div class="header">
                <div class="header-logo">
                    <div class="logo-box">U</div>
                    <div class="logo-text">University<span style="font-weight:normal;">News</span></div>
                </div>
                <h1>💳 Selesaikan Pembayaran<br>untuk Mempublikasikan Artikel</h1>
                <p class="header-sub">Artikel kamu telah disetujui — satu langkah lagi!</p>
            </div>

            <!-- Action badge -->
            <div class="badge-wrap">
                <span class="badge">
                    ⏳ &nbsp;Menunggu Pembayaran
                </span>
            </div>

            <!-- Body -->
            <div class="body">
                <p class="greeting">Halo, <strong>{{ $author->name }}</strong>!</p>
                <p class="intro">
                    Selamat! Admin telah mereview dan menyetujui artikel kamu di <strong>{{ config('app.name') }}</strong>.
                    Untuk menyelesaikan proses publikasi, kamu perlu melakukan pembayaran biaya publish terlebih dahulu.
                </p>

                <!-- Article info -->
                <div class="article-box">
                    <div class="article-label">Artikel yang disetujui</div>
                    <div class="article-title">{{ $article->title }}</div>
                    <div class="article-meta">
                        <span class="meta-chip">{{ $article->category->name ?? 'Uncategorized' }}</span>
                        <span class="meta-chip">Disubmit: {{ $article->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Schedule info -->
                <div class="schedule-box">
                    <div class="sch-label">📅 Jadwal Publish</div>
                    <div class="sch-date">
                        {{ $article->published_at ? $article->published_at->locale('id')->isoFormat('dddd, D MMMM YYYY · HH:mm') : '-' }} WIB
                    </div>
                    <div class="sch-note">Artikel akan otomatis tayang pada tanggal ini setelah pembayaran berhasil.</div>
                </div>

                @if($article->admin_notes)
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;padding:14px 18px;margin-bottom:24px;border-radius:2px;">
                    <div style="font-size:11px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#16a34a;margin-bottom:6px;font-family:Arial,sans-serif;">Catatan dari Admin</div>
                    <p style="font-size:13px;color:#374151;font-family:Arial,sans-serif;line-height:1.6;">{{ $article->admin_notes }}</p>
                </div>
                @endif

                <!-- Payment amount -->
                <div class="payment-box">
                    <div class="payment-label">Biaya Publish Artikel</div>
                    <div class="payment-amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    <div class="payment-note">Satu kali bayar · Artikel tayang permanen</div>
                </div>

                <!-- CTA -->
                <div class="cta-wrap">
                    <a href="{{ route('payment.show', $article) }}" class="btn">Bayar Sekarang</a>
                </div>

                <!-- Steps -->
                <div class="steps-title">Cara Melakukan Pembayaran</div>
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">Klik tombol <strong>"Bayar Sekarang"</strong> di atas untuk membuka halaman konfirmasi pembayaran.</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">Kamu akan diarahkan ke halaman pembayaran Mayar — pilih metode yang kamu inginkan: <strong>QRIS, Virtual Account Bank, atau e-Wallet</strong>.</div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">Selesaikan pembayaran. Artikel akan otomatis terpublish pada jadwal yang telah ditentukan.</div>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-text">Kamu akan menerima email konfirmasi setelah artikel berhasil terpublish.</div>
                </div>

                <!-- Warning -->
                <div class="warning">
                    <p>⚠️ <strong>Perhatian:</strong> Link pembayaran ini bersifat sementara dan memiliki batas waktu. Segera selesaikan pembayaran untuk memastikan artikel kamu terpublish sesuai jadwal.</p>
                </div>

                <hr class="divider">

                <p class="sign-off">
                    Terima kasih telah berkontribusi di <strong>{{ config('app.name') }}</strong>!<br>
                    Jika ada pertanyaan, balas email ini atau hubungi admin kami.<br><br>
                    Salam,<br>
                    <strong>Tim {{ config('app.name') }}</strong>
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                    Email ini dikirim karena artikel kamu telah disetujui oleh admin.<br>
                    Jika kamu tidak merasa mengajukan artikel, abaikan email ini.
                </p>
            </div>

        </div>
    </div>
</body>
</html>
