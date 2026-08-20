<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set Your Password — University News</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Work Sans', sans-serif; }
        .font-heading { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center items-center py-12 px-4 bg-[#fcf8f9] text-[#1b1b1c]">

    <div class="max-w-md w-full bg-white border border-[#c5c6cf] p-10 shadow-sm">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 rounded-full bg-[#00081e] flex items-center justify-center text-white">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-xl font-bold font-heading text-[#00081e]">Buat Password Akun Author</h1>
            <p class="text-xs text-gray-500 mt-2">Halo, <strong>{{ $user->name }}</strong>. Silakan buat password untuk akses CMS kamu.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-800 text-xs">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('author.set-password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Password Baru <span class="text-[#8b1528]">*</span>
                </label>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0"
                       placeholder="Minimal 8 karakter"
                       required>
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Konfirmasi Password <span class="text-[#8b1528]">*</span>
                </label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0"
                       placeholder="Ketik ulang password"
                       required>
            </div>

            <div class="pt-3">
                <button type="submit"
                        class="w-full py-3 bg-[#00081e] hover:bg-[#8b1528] text-white text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                    Aktivasi Akun &amp; Buat Password
                </button>
            </div>
        </form>

        <p class="text-center text-[11px] text-gray-400 mt-6">
            Setelah password dibuat, kamu dapat login dengan email dan password ini,
            atau tetap menggunakan Google Sign-In.
        </p>
    </div>
</body>
</html>
