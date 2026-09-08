<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'University News Portal') }} - Authentication</title>
    @if(request()->getHost() === 'devtest.univnews.site' || config('app.env') === 'staging')
        <meta name="robots" content="noindex, nofollow">
    @endif
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23B71032'/><text x='50' y='50' font-family='sans-serif' font-weight='bold' font-size='70' fill='white' dominant-baseline='central' text-anchor='middle'>U</text></svg>">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-text-main antialiased bg-navy min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Fullscreen Background Image Layer -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="https://images.unsplash.com/photo-1713633053651-0bb16c6dfa55?q=80&w=1920&auto=format&fit=crop" 
             alt="Background" 
             class="w-full h-full object-cover opacity-20">
    </div>

    <div class="w-full flex-grow flex flex-col py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="w-full max-w-7xl m-auto flex flex-col md:flex-row items-center justify-center gap-12">
            
            @if(isset($support))
            <!-- Support Center (Desktop left side, mobile stacked below or above depending on view) -->
            <div class="w-full md:w-1/3 shrink-0 hidden md:block">
                {{ $support }}
            </div>
            @endif

            <!-- Main Auth Card Container -->
            <div class="w-full max-w-md {{ isset($support) ? 'md:w-1/2 md:max-w-md' : 'mx-auto' }}">
                {{ $slot }}
            </div>

            @if(isset($support_mobile))
            <!-- Support Center (Mobile only) -->
            <div class="w-full block md:hidden mt-8">
                {{ $support_mobile }}
            </div>
            @endif
        </div>

    </div>
</body>
</html>
