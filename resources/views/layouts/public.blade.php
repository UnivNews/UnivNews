@extends('layouts.app')

@section('base_content')
    <header class="bg-navy text-white shadow-md sticky top-0 z-50">
        <div class="bg-crimson py-1 px-4 text-center text-xs tracking-widest uppercase font-heading font-bold">
            Official University News Portal
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="font-heading font-bold text-2xl tracking-tight flex items-center gap-2">
                        <div class="w-8 h-8 bg-crimson flex items-center justify-center font-serif text-white">U</div>
                        <span>University<span class="font-light">News</span></span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8 font-sans font-medium">
                    <a href="{{ route('home') }}" class="hover:text-crimson transition-colors px-3 py-2 text-sm uppercase tracking-wider {{ request()->routeIs('home') ? 'text-crimson border-b-2 border-crimson' : '' }}">Home</a>
                    <a href="{{ route('research') }}" class="hover:text-crimson transition-colors px-3 py-2 text-sm uppercase tracking-wider {{ request()->routeIs('research') ? 'text-crimson border-b-2 border-crimson' : '' }}">Research & Innovation</a>
                    <a href="{{ route('category', 'campus-life') }}" class="hover:text-crimson transition-colors px-3 py-2 text-sm uppercase tracking-wider">Campus Life</a>
                    <a href="{{ route('category', 'achievements') }}" class="hover:text-crimson transition-colors px-3 py-2 text-sm uppercase tracking-wider">Achievements</a>
                </nav>

                <!-- Search & Admin Link -->
                <div class="flex items-center space-x-6">
                    <form action="{{ route('search') }}" method="GET" class="hidden lg:block relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search news..." class="bg-white/10 border border-white/20 text-white placeholder-gray-400 px-4 py-1.5 focus:outline-none focus:border-crimson focus:ring-1 focus:ring-crimson w-48 transition-all">
                    </form>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-crimson hover:bg-red-700 text-white px-4 py-2 font-heading font-bold text-sm uppercase tracking-wider transition-colors">CMS</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-sans hover:text-crimson transition-colors">Staff Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-navy text-white mt-auto py-12 border-t-8 border-crimson">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ route('home') }}" class="font-heading font-bold text-2xl tracking-tight mb-4 inline-block">
                        University<span class="font-light">News</span>
                    </a>
                    <p class="text-gray-400 font-sans max-w-sm">
                        The official news portal delivering the latest updates on research, campus life, and achievements.
                    </p>
                </div>
                <div>
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block">Categories</h3>
                    <ul class="space-y-2 text-gray-400 font-sans">
                        <li><a href="{{ route('research') }}" class="hover:text-white transition-colors">Research & Innovation</a></li>
                        <li><a href="{{ route('category', 'campus-life') }}" class="hover:text-white transition-colors">Campus Life</a></li>
                        <li><a href="{{ route('category', 'achievements') }}" class="hover:text-white transition-colors">Achievements</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block">Connect</h3>
                    <ul class="space-y-2 text-gray-400 font-sans">
                        <li><a href="#" class="hover:text-white transition-colors">Twitter</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">LinkedIn</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">YouTube</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Press Office</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 font-sans text-sm">
                &copy; {{ date('Y') }} University News. All rights reserved. Strictly 0px border radii layout.
            </div>
        </div>
    </footer>
@endsection
