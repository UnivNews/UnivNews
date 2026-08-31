<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Terkirim — University News</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Work Sans', sans-serif; }
        .font-heading { font-family: 'Montserrat', sans-serif; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeInUp 0.5s ease-out forwards; }
    </style>
</head>
<body class="h-full flex flex-col justify-center items-center py-12 px-4 bg-[#fcf8f9] text-[#1b1b1c]">

    <div class="max-w-lg w-full bg-white border border-[#c5c6cf] p-10 shadow-sm fade-up">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold font-heading text-[#00081e] mb-2">Aplikasi Terkirim</h1>
            <div class="w-10 h-0.5 bg-[#8b1528] mx-auto"></div>
        </div>

        <!-- Message -->
        <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
            <p>
                Terima kasih, <strong class="text-[#00081e]">{{ $user->name }}</strong>.
                Aplikasi kamu untuk menjadi Author telah berhasil diterima oleh sistem kami
                dan saat ini berada dalam proses peninjauan oleh tim admin.
            </p>
            <p>
                Kami akan meninjau data dan kredensial yang kamu berikan. Proses ini biasanya
                memakan waktu <strong>1–3 hari kerja</strong>. Hasil dari peninjauan —
                baik disetujui maupun tidak — akan dikirimkan melalui email ke alamat
                <strong class="text-[#00081e]">{{ $user->email }}</strong>.
            </p>
            <p class="text-xs text-gray-500 bg-gray-50 p-3 border border-gray-200">
                📌 Mohon untuk memeriksa folder <strong>spam / promosi</strong> apabila email
                tidak kunjung diterima dalam waktu yang ditentukan.
            </p>
            <p class="text-xs text-gray-500">
                Jika ada pertanyaan lebih lanjut, silakan hubungi tim kami melalui
                <a href="mailto:{{ config('mail.from.address') }}" class="text-[#8b1528] hover:underline">
                    {{ config('mail.from.address') }}
                </a>.
            </p>
        </div>

        <!-- Status Badge -->
        <div class="mt-6 flex items-center gap-2 p-3 bg-yellow-50 border border-yellow-200">
            <span class="w-2 h-2 rounded-full bg-yellow-500 flex-shrink-0 animate-pulse"></span>
            <span class="text-xs font-semibold text-yellow-800 font-heading uppercase tracking-wider">Status: Pending Review</span>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-3 pt-6 border-t border-gray-100">
            <a href="{{ route('home') }}"
               class="text-xs text-gray-500 hover:text-[#00081e] uppercase font-semibold tracking-wide transition-colors">
                &larr; Kembali ke Portal
            </a>
            <a href="{{ route('author.apply') }}"
               class="text-xs text-gray-400 hover:text-gray-600 underline transition-colors">
                Lihat status aplikasi
            </a>
        </div>
    </div>
</body>
</html>
