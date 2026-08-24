<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CMS Portal - University News')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600;0,8..60,700;1,8..60,400&family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind & App Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js is bundled with Vite/Breeze -->
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Work Sans', sans-serif; color: #1b1b1c; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Montserrat', sans-serif; }
        .font-serif-content { font-family: 'Source Serif 4', serif; }
    </style>
</head>
<body class="h-full overflow-hidden antialiased bg-[#f4f6f8] text-[#1b1b1c]">
    <div class="flex h-screen overflow-hidden" x-data="{ mobileSidebarOpen: false }">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="mobileSidebarOpen" 
             x-cloak
             @click="mobileSidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/60 md:hidden"></div>

        <!-- Sidebar -->
        <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#030919] text-white transition-transform duration-200 ease-in-out md:static md:translate-x-0 flex flex-col flex-shrink-0 select-none shadow-xl md:shadow-none">
            
            <!-- Logo Header -->
            <div class="p-6 border-b border-gray-800/80">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded bg-[#8b1528] flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-extrabold tracking-tight font-heading text-white group-hover:text-red-400 transition-colors leading-tight">CMS Portal</div>
                        <div class="text-xs text-gray-400 font-sans tracking-wide">University News</div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-6 space-y-1.5 px-0">
                @php
                    $isAdmin = auth()->user()->isAdmin();
                    $isAuthor = auth()->user()->isAuthor();
                @endphp

                <!-- Dashboard -->
                <a href="{{ $isAdmin ? route('admin.dashboard') : route('author.dashboard') }}" 
                   class="flex items-center px-6 py-3.5 text-sm font-medium transition-colors {{ request()->routeIs('*.dashboard') ? 'bg-[#8b1528] text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="3" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Articles -->
                <a href="{{ $isAdmin ? route('admin.articles.index') : route('author.articles.index') }}" 
                   class="flex items-center px-6 py-3.5 text-sm font-medium transition-colors {{ request()->routeIs('*articles*') ? 'bg-[#8b1528] text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Articles
                </a>

                <!-- Users / Authors Management (Admin only) -->
                @if($isAdmin)
                <a href="{{ route('admin.authors.index') }}" 
                   class="flex items-center px-6 py-3.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.authors*') || request()->routeIs('admin.users*') ? 'bg-[#8b1528] text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </a>

                <a href="{{ route('admin.universities.index') }}" 
                   class="flex items-center px-6 py-3.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.universities*') ? 'bg-[#8b1528] text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Universities
                </a>

                {{-- App Settings: payment fee, etc. (Admin only) --}}
                <a href="{{ route('admin.app-settings.index') }}" 
                   class="flex items-center px-6 py-3.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.app-settings*') ? 'bg-[#8b1528] text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Payment Settings
                </a>
                @endif

                <!-- Settings (User Profile) -->
                <a href="{{ $isAdmin ? route('admin.settings.edit') : route('author.settings.edit') }}" 
                   class="flex items-center px-6 py-3.5 text-sm font-medium transition-colors {{ request()->routeIs('*.settings*') || request()->routeIs('*.profile*') ? 'bg-[#8b1528] text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3.5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </nav>

            <!-- Bottom Log Out -->
            <div class="p-4 border-t border-gray-800/80">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-gray-400 hover:text-white hover:bg-white/5 transition-colors text-sm font-medium">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden min-w-0">
            
            <!-- Top Header Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger -->
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="md:hidden text-gray-700 hover:text-navy p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <!-- Subheader / Title Tagline -->
                    <div class="text-xs font-heading font-bold uppercase tracking-wider text-[#8b1528] hidden sm:block">
                        @yield('header_tagline', 'University News CMS')
                    </div>
                </div>

                <!-- Center Search Input -->
                <div class="hidden md:flex items-center max-w-sm w-full mx-6">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               placeholder="Search..." 
                               class="w-full pl-9 pr-4 py-1.5 bg-[#f8f9fa] border border-gray-300 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0 transition-colors">
                    </div>
                </div>

                <!-- Right Utility Icons & User Info -->
                <div class="flex items-center space-x-5 text-gray-500">
                    <!-- Notification Bell -->
                    <button class="hover:text-navy transition-colors relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>

                    <!-- Help Question Icon -->
                    <button class="hover:text-navy transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>

                    <div class="h-6 w-px bg-gray-200"></div>

                    <!-- User Pill -->
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs font-sans text-gray-600 hidden sm:inline-block">Logged in as: <strong class="text-navy font-semibold text-gray-900">{{ auth()->user()->name }}</strong></span>
                        <div class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-bold text-xs overflow-hidden border border-gray-200">
                            @if(auth()->user()->avatar_path)
                                <img src="{{ asset(auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="uppercase">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8f9fa] p-6 lg:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-600 text-green-800 text-sm font-sans flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 text-red-800 text-sm font-sans flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-red-600 hover:text-red-800">&times;</button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
