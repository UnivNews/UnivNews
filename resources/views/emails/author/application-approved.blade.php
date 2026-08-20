<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #ffffff; border: 1px solid #e2e8f0; }
        .header { background: #00081e; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 20px; margin: 0; letter-spacing: 1px; }
        .header p { color: #86efac; font-size: 12px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .body h2 { color: #00081e; font-size: 18px; margin: 0 0 12px; }
        .body p { color: #4a5568; font-size: 14px; line-height: 1.8; margin: 0 0 16px; }
        .status-box { background: #f0fdf4; border-left: 4px solid #16a34a; padding: 16px 20px; margin: 24px 0; border-radius: 0 4px 4px 0; }
        .status-box p { margin: 0; color: #14532d; font-size: 13px; }
        .cta-btn { display: inline-block; background: #8b1528; color: #ffffff !important; padding: 14px 28px; text-decoration: none; font-weight: bold; font-size: 14px; margin: 24px 0; letter-spacing: 0.5px; }
        .notice { background: #fff7ed; border: 1px solid #fed7aa; padding: 12px 16px; font-size: 12px; color: #9a3412; border-radius: 4px; margin-top: 12px; }
        .footer { padding: 20px 40px; background: #f8f9fa; border-top: 1px solid #e2e8f0; text-align: center; }
        .footer p { color: #94a3b8; font-size: 11px; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>UNIVERSITY NEWS</h1>
            <p>✅ Application Approved</p>
        </div>
        <div class="body">
            <h2>Selamat, {{ $applicant->name }}! 🎉</h2>
            <p>
                Aplikasi kamu untuk menjadi Author di <strong>{{ config('app.name') }}</strong> telah
                <strong>disetujui</strong> oleh tim editorial kami. Selamat datang di tim kontributor!
            </p>

            <div class="status-box">
                <p>
                    ✅ <strong>Status: Disetujui</strong><br>
                    Akun authormu telah aktif. Langkah terakhir: buat password untuk akun CMS kamu.
                </p>
            </div>

            <p>
                Klik tombol di bawah untuk mengatur password dan mengaktifkan akses dashboard author kamu:
            </p>

            <div style="text-align: center; margin: 28px 0;">
                <a href="{{ url('/author/set-password?token=' . $approvalToken->token) }}" class="cta-btn">
                    Buat Password &amp; Aktifkan Akun
                </a>
            </div>

            <div class="notice">
                ⚠️ <strong>Link ini berlaku selama 48 jam</strong> dan hanya dapat digunakan satu kali.
                Jika sudah kadaluarsa, kamu bisa meminta link baru melalui halaman yang muncul saat link dibuka.
            </div>

            <p style="margin-top: 20px;">
                Jika tombol di atas tidak berfungsi, salin dan tempel URL ini ke browser kamu:<br>
                <small style="color: #6b7280; word-break: break-all;">
                    {{ url('/author/set-password?token=' . $approvalToken->token) }}
                </small>
            </p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis. Mohon jangan membalas email ini langsung.</p>
            <p style="margin-top: 4px;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
