<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #ffffff; border: 1px solid #e2e8f0; }
        .header { background: #00081e; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 20px; margin: 0; letter-spacing: 1px; }
        .header p { color: #fca5a5; font-size: 12px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .body h2 { color: #00081e; font-size: 18px; margin: 0 0 12px; }
        .body p { color: #4a5568; font-size: 14px; line-height: 1.8; margin: 0 0 16px; }
        .status-box { background: #fef2f2; border-left: 4px solid #dc2626; padding: 16px 20px; margin: 24px 0; border-radius: 0 4px 4px 0; }
        .status-box p { margin: 0; color: #7f1d1d; font-size: 13px; }
        .reason-box { background: #f8f9fa; border: 1px solid #e2e8f0; padding: 16px 20px; margin: 16px 0; font-style: italic; font-size: 13px; color: #4a5568; border-radius: 4px; }
        .footer { padding: 20px 40px; background: #f8f9fa; border-top: 1px solid #e2e8f0; text-align: center; }
        .footer p { color: #94a3b8; font-size: 11px; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>UNIVERSITY NEWS</h1>
            <p>Author Application Update</p>
        </div>
        <div class="body">
            <h2>Halo, {{ $applicant->name }},</h2>
            <p>
                Terima kasih telah mengirimkan aplikasi untuk menjadi Author di <strong>{{ config('app.name') }}</strong>.
                Setelah melalui proses peninjauan, kami harus menyampaikan bahwa aplikasimu <strong>belum dapat disetujui</strong> saat ini.
            </p>

            <div class="status-box">
                <p>
                    ❌ <strong>Status: Tidak Disetujui</strong>
                </p>
            </div>

            @if($reason)
            <p><strong>Catatan dari tim editorial:</strong></p>
            <div class="reason-box">
                "{{ $reason }}"
            </div>
            @endif

            <p>
                Kamu masih bisa mengajukan kembali aplikasimu di lain waktu dengan melengkapi
                informasi yang lebih detail tentang rencana kontribusimu.
            </p>
            <p>
                Jika ada pertanyaan, silakan hubungi tim kami melalui
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
