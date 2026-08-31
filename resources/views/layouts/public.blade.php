@extends('layouts.app')

@section('base_content')
<div class="min-h-screen flex flex-col w-full">
    <!-- Top Announcement Bar -->
    <div class="bg-crimson text-white text-xs font-bold uppercase tracking-widest text-center py-2 w-full font-sans">
        OFFICIAL UNIVERSITY NEWS PORTAL
    </div>

    <header class="bg-navy text-white shadow-md sticky top-0 z-50">
        <div class="w-full px-2 sm:px-6 md:px-10 lg:px-12 xl:px-16 overflow-hidden">
            <div class="flex justify-between items-center h-16 sm:h-20">
                
                <!-- Left: Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-1.5 sm:space-x-3 group">
                        <div class="bg-crimson text-white w-7 h-7 sm:w-10 sm:h-10 flex items-center justify-center font-heading font-bold text-lg sm:text-2xl transition-transform group-hover:scale-105">
                            U
                        </div>
                        <span class="font-heading font-bold text-base sm:text-2xl tracking-tight">
                            University<span class="font-normal hidden sm:inline">News</span>
                        </span>
                    </a>
                </div>

                <!-- Right: Search & Login -->
                <div class="flex items-center justify-end space-x-1 sm:space-x-3 md:space-x-6 flex-shrink-0 h-8 sm:h-10">
                    
                    <!-- Filter/Mega Menu Trigger -->
                    <div x-data="{ openMegaMenu: false }" @click.outside="openMegaMenu = false" class="h-full flex items-center justify-center px-1 sm:px-2 cursor-pointer z-50">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white hover:text-gray-300 transition-colors cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" @click="openMegaMenu = !openMegaMenu">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                        
                        <!-- Mega Menu Dropdown -->
                        <div x-show="openMegaMenu" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="absolute top-full left-0 w-full bg-white/95 backdrop-blur-md shadow-[0_15px_40px_rgba(0,0,0,0.15)] border-t-2 border-crimson cursor-default overflow-hidden z-50"
                             style="display: none;">
                            <!-- Bridge to prevent hover gap -->
                            <div class="absolute -top-10 right-0 w-64 h-10 bg-transparent"></div>
                            
                            <!-- Categories Section (Top) -->
                            <div class="p-4 sm:p-8 max-w-[1280px] mx-auto w-full max-h-[75vh] overflow-y-auto">
                                <h3 class="text-gray-500 font-sans text-xs uppercase tracking-widest font-bold mb-4">Top Categories</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6">
                                    <!-- ACHIEVEMENTS -->
                                    <a href="{{ route('achievements') }}" class="group/card relative h-24 sm:h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-2.5 sm:pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-xs sm:text-sm uppercase px-2.5 sm:px-4 py-1 sm:py-1.5 shadow-lg tracking-wider rounded-sm">Achievements</span>
                                        </div>
                                    </a>
                                    <!-- EVENTS -->
                                    <a href="{{ route('events') }}" class="group/card relative h-24 sm:h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-2.5 sm:pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-xs sm:text-sm uppercase px-3 sm:px-4 py-1 sm:py-1.5 shadow-lg tracking-wider rounded-sm">Events</span>
                                        </div>
                                    </a>
                                    <!-- RESEARCH -->
                                    <a href="{{ route('research') }}" class="group/card relative h-24 sm:h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-2.5 sm:pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-xs sm:text-sm uppercase px-3 sm:px-4 py-1 sm:py-1.5 shadow-lg tracking-wider rounded-sm">Research & Innovation</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Tags Section (Bottom) -->
                            <div class="bg-gray-50/50 border-t border-gray-200/50">
                                <div class="p-4 sm:p-6 max-w-[1280px] mx-auto w-full">
                                    <h3 class="text-gray-500 font-sans text-xs uppercase tracking-widest font-bold mb-3 sm:mb-4 flex justify-between items-center">
                                        <span>Browse by Tags</span>
                                    </h3>
                                    <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                        @php
                                            $menuTags = \App\Models\Tag::orderBy('name')->get();
                                        @endphp
                                        @foreach($menuTags as $menuTag)
                                        <a href="{{ route('tag', $menuTag->name) }}" class="px-2.5 sm:px-4 py-1.5 sm:py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-[11px] sm:text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">{{ $menuTag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Search Form -->
                    <form action="{{ route('search') }}" method="GET" class="hidden lg:flex relative h-full items-center">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search news..." class="bg-[#0A1F44] text-white placeholder-[#7687B2] border border-transparent focus:border-crimson px-4 h-full focus:outline-none w-44 xl:w-56 transition-all rounded-none font-sans text-sm">
                        <button type="submit" class="bg-crimson hover:bg-red-700 text-white px-3 h-full flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                    
                    @auth
                        {{-- @auth hanya mendeteksi web guard (author/reader) --}}
                        {{-- Admin menggunakan guard terpisah, tidak terdeteksi di sini --}}
                        @if(auth()->user()->isAuthor())
                            <a href="{{ route('author.dashboard') }}" class="h-full flex items-center bg-crimson hover:bg-red-700 text-white px-3 sm:px-4 font-heading font-bold text-xs uppercase tracking-wider transition-colors whitespace-nowrap">Author Desk</a>
                        @else
                            <a href="{{ route('author.apply') }}" class="h-full flex items-center justify-center border border-white/30 text-white hover:bg-crimson hover:border-crimson px-3 sm:px-4 font-sans font-medium text-xs tracking-wider transition-colors whitespace-nowrap">Apply as Author</a>
                            <a href="{{ route('profile.edit') }}" class="h-full flex items-center ml-2 focus:outline-none" title="Profile">
                                <img src="{{ asset('user-1.png') }}" alt="Profile" class="w-8 h-8 sm:w-9 sm:h-9 object-cover rounded-full border-2 border-transparent hover:border-crimson hover:opacity-90 transition-all">
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="h-full flex items-center text-xs sm:text-sm font-sans font-medium text-white hover:text-crimson transition-colors px-2">Login</a>
                        <a href="{{ route('register') }}" class="h-full flex items-center bg-crimson hover:bg-red-700 text-white px-3 sm:px-4 text-xs font-heading font-bold uppercase tracking-wider transition-colors whitespace-nowrap">Register</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="block lg:hidden bg-[#0A1F44] border-t border-white/10 px-4 py-2">
            <form action="{{ route('search') }}" method="GET" class="w-full flex">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search news..." class="flex-grow bg-[#00081E] text-white placeholder-[#7687B2] border border-transparent focus:border-crimson px-3 py-1.5 focus:outline-none font-sans text-xs rounded-none">
                <button type="submit" class="bg-crimson hover:bg-red-700 text-white px-3 py-1.5 flex items-center justify-center transition-colors rounded-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
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
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Faculty Experts</a></li>
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Media Relations</a></li>
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Archives</a></li>
                    </ul>
                </div>
                <div>
                    @php
                        $adminUser = \App\Models\User::where('role', 'admin')->first();
                        $socials = $adminUser ? ($adminUser->social_links ?? []) : [];
                    @endphp
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block text-crimson">SOCIAL</h3>
                    <ul class="space-y-2 text-gray-400 font-sans text-sm">
                        @if(!empty($socials['instagram']))
                        <li><a href="https://instagram.com/{{ ltrim($socials['instagram'], '@') }}" target="_blank" rel="noopener" class="hover:text-white transition-colors">Instagram</a></li>
                        @endif
                        @if(!empty($socials['twitter']))
                        <li><a href="https://x.com/{{ ltrim($socials['twitter'], '@') }}" target="_blank" rel="noopener" class="hover:text-white transition-colors">X / Twitter</a></li>
                        @endif
                        @if(!empty($socials['threads']))
                        <li><a href="https://threads.net/@{{ ltrim($socials['threads'], '@') }}" target="_blank" rel="noopener" class="hover:text-white transition-colors">Threads</a></li>
                        @endif
                        @if(!empty($socials['linkedin']))
                        <li><a href="https://linkedin.com/in/{{ $socials['linkedin'] }}" target="_blank" rel="noopener" class="hover:text-white transition-colors">LinkedIn</a></li>
                        @endif
                        @if(empty($socials['instagram']) && empty($socials['twitter']) && empty($socials['threads']) && empty($socials['linkedin']))
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Newsletter</a></li>
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Podcasts</a></li>
                        <li><a href="{{ route('events') }}" class="hover:text-white transition-colors">Events</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading font-bold uppercase tracking-wider mb-4 border-b border-gray-700 pb-2 inline-block text-crimson">INSTITUTION</h3>
                    <ul class="space-y-2 text-gray-400 font-sans text-sm">
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">About the University</a></li>
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Admissions</a></li>
                        <li><a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Giving</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-[#C5C6CF] mt-12 pt-8 flex flex-col md:flex-row justify-between items-center font-sans text-sm" style="color: #7687B2;">
                <div>
                    &copy; 2024 University News Portal. All academic rights reserved.
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" onclick="alert('Feature coming soon!'); return false;" class="hover:text-white transition-colors">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
