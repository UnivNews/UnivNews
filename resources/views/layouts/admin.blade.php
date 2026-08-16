@extends('layouts.app')

@section('base_content')
    <div class="flex h-screen overflow-hidden bg-background">
        <!-- Sidebar -->
        <aside class="w-64 bg-navy text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 border-b border-gray-800">
                <a href="{{ route('home') }}" target="_blank" class="text-xl font-heading font-bold text-white hover:text-crimson transition-colors flex items-center gap-2">
                    <div class="w-6 h-6 bg-crimson flex items-center justify-center font-serif text-sm">U</div>
                    CMS Portal
                </a>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-4 mb-2 text-xs font-heading font-bold uppercase tracking-wider text-gray-400">Main</div>
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-crimson text-white border-l-4 border-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white border-l-4 border-transparent transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                <div class="px-4 mt-6 mb-2 text-xs font-heading font-bold uppercase tracking-wider text-gray-400">Content</div>
                <a href="{{ route('admin.articles') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.articles*') ? 'bg-crimson text-white border-l-4 border-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white border-l-4 border-transparent transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"></path></svg>
                    Articles
                </a>
                <a href="{{ route('admin.articles.create') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.articles.create') ? 'bg-crimson text-white border-l-4 border-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white border-l-4 border-transparent transition-colors' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Article
                </a>
                @endif
            </nav>
            
            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-400 hover:text-white transition-colors text-sm">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="h-16 bg-surface border-b border-border-main flex items-center justify-between px-6">
                <div class="flex items-center">
                    <button class="md:hidden text-text-main mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <span class="font-heading font-bold text-navy uppercase tracking-wider text-sm hidden sm:block">@yield('title', 'Admin Panel')</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 font-sans hidden sm:inline-block">Logged in as: <strong class="text-navy">{{ auth()->user()->name ?? 'Guest' }}</strong></span>
                </div>
            </header>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
@endsection
