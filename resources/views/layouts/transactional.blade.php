@extends('layouts.app')

@section('base_content')
    <header class="bg-navy text-white shadow-md sticky top-0 z-50">
        <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10">
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

                <!-- Right: Back -->
                <div class="flex items-center justify-end flex-shrink-0 h-10">
                    <a href="{{ route('home') }}" class="flex items-center text-white hover:text-gray-300 transition-colors font-sans font-bold text-sm tracking-wider uppercase">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        BACK
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow bg-[#FCF8F9] min-h-[calc(100vh-80px-300px)]">
        @yield('content')
    </main>

    <footer class="bg-navy text-white mt-auto py-12 border-t border-crimson">
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
            
            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center text-sm font-sans" style="color: #7687B2;">
                <p>&copy; 2024 University News Portal. All academic rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Accessibility</a>
                    <a href="#" class="hover:text-white transition-colors">Contact Support</a>
                </div>
            </div>
        </div>
    </footer>
@endsection
