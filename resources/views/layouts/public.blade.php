@extends('layouts.app')

@section('base_content')
    <!-- Top Announcement Bar -->
    <div class="bg-crimson text-white text-xs font-bold uppercase tracking-widest text-center py-2 w-full font-sans">
        OFFICIAL UNIVERSITY NEWS PORTAL
    </div>

    <header class="bg-navy text-white shadow-md sticky top-0 z-50">
        <div class="w-full px-6 md:px-10 lg:px-12 xl:px-16">
            <div class="flex justify-between items-center h-20">
                
                <!-- Left: Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="bg-crimson text-white w-10 h-10 flex items-center justify-center font-heading font-bold text-2xl transition-transform group-hover:scale-105">
                            U
                        </div>
                        <span class="font-heading font-bold text-2xl tracking-tight">
                            University<span class="font-normal">News</span>
                        </span>
                    </a>
                </div>

                <!-- Center: Navigation -->
                <nav class="hidden lg:flex items-center justify-center space-x-8 font-sans font-bold text-[11px] uppercase tracking-wider flex-1 px-8">
                    <a href="{{ route('home') }}" class="hover:text-crimson transition-colors px-1 py-7 {{ request()->routeIs('home') ? 'text-crimson border-b-2 border-crimson' : 'text-white border-b-2 border-transparent' }}">HOME</a>
                    <a href="{{ route('category', 'achievements') }}" class="hover:text-crimson transition-colors px-1 py-7 {{ request()->is('category/achievements') ? 'text-crimson border-b-2 border-crimson' : 'text-white border-b-2 border-transparent' }}">ACHIEVEMENTS</a>
                    <a href="{{ route('events') }}" class="hover:text-crimson transition-colors px-1 py-7 {{ request()->routeIs('events') ? 'text-crimson border-b-2 border-crimson' : 'text-white border-b-2 border-transparent' }}">EVENTS</a>
                    <a href="{{ route('research') }}" class="hover:text-crimson transition-colors px-1 py-7 {{ request()->routeIs('research') ? 'text-crimson border-b-2 border-crimson' : 'text-white border-b-2 border-transparent' }}">RESEARCH & INNOVATION</a>
                </nav>

                <!-- Right: Search & Login -->
                <div class="flex items-center justify-end space-x-6 flex-shrink-0 h-10">
                    <a href="{{ route('profile.edit') }}" class="h-full flex items-center justify-center hover:opacity-80 transition-opacity px-2" title="Settings">
                        <img src="{{ asset('setting-1.png') }}" alt="Settings" class="w-6 h-6 object-contain">
                    </a>
                    <form action="{{ route('search') }}" method="GET" class="hidden lg:block relative h-full">
                        <div class="relative h-full">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-4 h-4" style="color: #7687B2;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search news..." class="bg-[#0A1F44] text-white placeholder-[#7687B2] border border-transparent focus:border-crimson pl-10 pr-4 h-full focus:outline-none w-56 transition-all rounded-none font-sans text-sm">
                        </div>
                    </form>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="h-full flex items-center bg-crimson hover:bg-red-700 text-white px-4 font-heading font-bold text-xs uppercase tracking-wider transition-colors">Admin CMS</a>
                        @elseif(auth()->user()->isAuthor())
                            <a href="{{ route('author.dashboard') }}" class="h-full flex items-center bg-crimson hover:bg-red-700 text-white px-4 font-heading font-bold text-xs uppercase tracking-wider transition-colors">Author Desk</a>
                        @else
                            <a href="{{ route('author.apply') }}" class="h-full flex items-center justify-center border border-white/30 text-white hover:bg-crimson hover:border-crimson px-4 font-sans font-medium text-xs tracking-wider transition-colors">Apply as Author</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="h-full flex items-center ml-2 focus:outline-none" title="Profile">
                            <img src="{{ asset('user-1.png') }}" alt="Profile" class="w-9 h-9 object-cover rounded-full border-2 border-transparent hover:border-crimson hover:opacity-90 transition-all">
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="h-full flex items-center text-sm font-sans font-medium text-white hover:text-crimson transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="h-full flex items-center bg-crimson hover:bg-red-700 text-white px-4 text-xs font-heading font-bold uppercase tracking-wider transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-navy text-white mt-auto py-12 border-t-8 border-crimson">
        <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h2 class="font-heading font-bold text-2xl tracking-tight mb-4" style="color: #FFFFFF;">
                        University News
                    </h2>
                    <p class="font-sans text-sm leading-relaxed" style="color: #7687B2;">
                        Providing authoritative reporting and intellectual discourse for the academic community since 1893.
                    </p>
                </div>
                <div>
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block text-crimson">RESOURCES</h3>
                    <ul class="space-y-2 text-gray-400 font-sans text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Faculty Experts</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Media Relations</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Archives</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block text-crimson">SOCIAL</h3>
                    <ul class="space-y-2 text-gray-400 font-sans text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Newsletter</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Podcasts</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Events</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block text-crimson">INSTITUTION</h3>
                    <ul class="space-y-2 text-gray-400 font-sans text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">About the University</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Admissions</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Giving</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-[#C5C6CF] mt-12 pt-8 flex flex-col md:flex-row justify-between items-center font-sans text-sm" style="color: #7687B2;">
                <div>
                    &copy; 2024 University News Portal. All academic rights reserved.
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>
@endsection
