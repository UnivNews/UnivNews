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



                <!-- Right: Search & Login -->
                <div class="flex items-center justify-end space-x-6 flex-shrink-0 h-10">
                    <!-- Filter/Mega Menu Trigger -->
                    <div x-data="{ openMegaMenu: false }" @click.outside="openMegaMenu = false" class="h-full flex items-center justify-center px-2 cursor-pointer z-50">
                        <img src="{{ asset('setting-1.png') }}" alt="Filter Menu" class="w-6 h-6 object-contain hover:opacity-80 transition-opacity" @click="openMegaMenu = !openMegaMenu">
                        
                        <!-- Mega Menu Dropdown -->
                        <div x-show="openMegaMenu" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="absolute top-full left-0 w-full bg-white/80 backdrop-blur-md shadow-[0_15px_40px_rgba(0,0,0,0.15)] border-t-2 border-crimson cursor-default overflow-hidden z-50"
                             style="display: none;">
                            <!-- Bridge to prevent hover gap -->
                            <div class="absolute -top-10 right-0 w-64 h-10 bg-transparent"></div>
                            
                            <!-- Categories Section (Top) -->
                            <div class="p-8 max-w-[1280px] mx-auto w-full">
                                <h3 class="text-gray-500 font-sans text-xs uppercase tracking-widest font-bold mb-4">Top Categories</h3>
                                <div class="grid grid-cols-4 gap-6">
                                    <!-- HOME -->
                                    <a href="{{ route('home') }}" class="group/card relative h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-sm uppercase px-4 py-1.5 shadow-lg tracking-wider rounded-sm">Home</span>
                                        </div>
                                    </a>
                                    <!-- ACHIEVEMENTS -->
                                    <a href="{{ route('category', 'achievements') }}" class="group/card relative h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-sm uppercase px-4 py-1.5 shadow-lg tracking-wider rounded-sm">Achievements</span>
                                        </div>
                                    </a>
                                    <!-- EVENTS -->
                                    <a href="{{ route('events') }}" class="group/card relative h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-sm uppercase px-4 py-1.5 shadow-lg tracking-wider rounded-sm">Events</span>
                                        </div>
                                    </a>
                                    <!-- RESEARCH -->
                                    <a href="{{ route('research') }}" class="group/card relative h-40 rounded-lg overflow-hidden flex items-end shadow-md bg-white/50 border border-gray-200/50">
                                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=400&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110 opacity-80 group-hover/card:opacity-100">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                        <div class="relative w-full text-center pb-4 z-10 flex justify-center">
                                            <span class="bg-crimson text-white font-heading font-extrabold text-sm uppercase px-4 py-1.5 shadow-lg tracking-wider rounded-sm">Research</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Tags Section (Bottom) -->
                            <div class="bg-gray-50/50 border-t border-gray-200/50">
                                <div class="p-6 max-w-[1280px] mx-auto w-full">
                                    <h3 class="text-gray-500 font-sans text-xs uppercase tracking-widest font-bold mb-4 flex justify-between items-center">
                                        <span>Browse by Tags</span>
                                        <a href="#" class="text-crimson hover:text-red-800 capitalize font-normal text-xs transition-colors">View all tags ></a>
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Akademik</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Beasiswa</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Penelitian</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Mahasiswa</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Fasilitas</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Olahraga</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Seni & Budaya</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Prestasi</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Seminar</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Inovasi</a>
                                        <a href="#" class="px-4 py-2 bg-white hover:bg-crimson text-gray-700 hover:text-white rounded shadow-sm text-xs font-sans transition-colors border border-gray-200 hover:border-crimson tracking-wide">Alumni</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
