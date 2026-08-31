<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Disetujui — University News</title>
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
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-9 h-9 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold font-heading text-[#00081e] mb-2">Aplikasi Disetujui! 🎉</h1>
            <div class="w-10 h-0.5 bg-[#8b1528] mx-auto"></div>
        </div>

        <!-- Message -->
        <div class="space-y-4 text-sm text-gray-600 leading-relaxed text-center">
            <p>
                Selamat, <strong class="text-[#00081e]">{{ $user->name }}</strong>!
                Aplikasi kamu untuk menjadi Author telah <strong class="text-green-600">disetujui</strong> oleh tim admin.
            </p>
            <p>
                Untuk mulai menulis dan mengakses dashboard author, kamu perlu mengatur password akun kamu terlebih dahulu melalui link yang telah kami kirimkan ke email: 
                <br>
                <strong class="text-[#00081e]">{{ $user->email }}</strong>
            </p>
            
            <div class="pt-4">
                @php
                    // Create a link that forces Google Account Chooser for a specific email
                    $gmailUrl = "https://accounts.google.com/AccountChooser?Email=" . urlencode($user->email) . "&continue=https://mail.google.com/mail/";
                @endphp
                <a href="{{ str_contains($user->email, '@gmail.com') ? $gmailUrl : 'https://mail.google.com' }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Buka Email Sekarang
                </a>
            </div>

            <p class="text-xs text-gray-500 bg-gray-50 p-3 border border-gray-200 mt-4 text-left">
                📌 Mohon periksa folder <strong>spam / promosi</strong> apabila email aktivasi tidak terlihat di kotak masuk utama.
            </p>
        </div>

        <!-- Status Badge -->
        <div class="mt-6 flex items-center gap-2 p-3 bg-green-50 border border-green-200 justify-center">
            <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>
            <span class="text-xs font-semibold text-green-800 font-heading uppercase tracking-wider">Status: Approved</span>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex items-center justify-center pt-6 border-t border-gray-100">
            <a href="{{ route('home') }}"
               class="text-xs text-gray-500 hover:text-[#00081e] uppercase font-semibold tracking-wide transition-colors">
                &larr; Kembali ke Portal
            </a>
        </div>
    </div>
</body>
</html>
