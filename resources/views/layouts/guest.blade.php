<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'University News Portal') }} - Authentication</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-text-main antialiased bg-background min-h-screen flex flex-col">

    <div class="flex-grow flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="w-full max-w-7xl mx-auto flex flex-col md:flex-row items-start justify-center gap-12">
            
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

    <!-- Footer -->
    <footer class="py-8 border-t border-border-main mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-500 text-center md:text-left">
                &copy; {{ date('Y') }} {{ config('app.name', 'University News') }}. All rights reserved.
            </div>
            <div class="flex space-x-6 text-sm text-gray-500">
                <a href="{{ config('support.privacy_url', '#') }}" class="hover:text-navy transition-colors">Privacy Policy</a>
                <a href="{{ config('support.terms_url', '#') }}" class="hover:text-navy transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>
</html>
