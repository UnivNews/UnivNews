<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #ffffff; border: 1px solid #e2e8f0; }
        .header { background: #00081e; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 20px; margin: 0; letter-spacing: 1px; }
        .header p { color: #94a3b8; font-size: 12px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .body h2 { color: #00081e; font-size: 18px; margin: 0 0 12px; }
        .body p { color: #4a5568; font-size: 14px; line-height: 1.8; margin: 0 0 16px; }
        .status-box { background: #fefce8; border-left: 4px solid #eab308; padding: 16px 20px; margin: 24px 0; border-radius: 0 4px 4px 0; }
        .status-box p { margin: 0; color: #713f12; font-size: 13px; }
        .footer { padding: 20px 40px; background: #f8f9fa; border-top: 1px solid #e2e8f0; text-align: center; }
        .footer p { color: #94a3b8; font-size: 11px; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>UNIVERSITY NEWS</h1>
            <p>Author Application System</p>
        </div>
        <div class="body">
            <h2>Halo, {{ $applicant->name }}! 👋</h2>
            <p>
                Terima kasih telah mengajukan aplikasi untuk menjadi Author di <strong>{{ config('app.name') }}</strong>.
                Aplikasi kamu telah berhasil diterima oleh sistem kami.
            </p>

            <div class="status-box">
                <p>
                    ⏳ <strong>Status: Sedang Ditinjau</strong><br>
                    Tim editorial kami akan meninjau data dan kredensial yang kamu berikan.
                    Proses ini biasanya memakan waktu <strong>1–3 hari kerja</strong>.
                </p>
            </div>

            <p>
                Hasil dari peninjauan — baik disetujui maupun tidak — akan dikirimkan melalui email
                ke alamat <strong>{{ $applicant->email }}</strong>.
            </p>
            <p>
                Mohon periksa folder <strong>spam/promosi</strong> apabila email tidak kunjung diterima
                dalam waktu yang ditentukan.
            </p>
            <p>
                Jika ada pertanyaan lebih lanjut, silakan hubungi tim kami melalui
                <a href="mailto:{{ config('mail.from.address') }}" style="color: #8b1528;">{{ config('mail.from.address') }}</a>.
            </p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis. Mohon jangan membalas email ini langsung.</p>
            <p style="margin-top: 4px;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
