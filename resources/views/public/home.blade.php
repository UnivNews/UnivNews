@extends('layouts.public')

@section('title', 'University News - Home')

@section('content')

<style>
    @keyframes marquee {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-100%); }
    }
    .animate-marquee {
        animation: marquee 20s linear infinite;
    }
    .group:hover .animate-marquee {
        animation-play-state: paused;
    }
</style>

<!-- Breaking News Section -->
<section class="bg-navy py-8 lg:py-12">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10">
        <!-- Section Label -->
        <div class="flex items-center mb-8">
            <span class="w-2 h-2 rounded-full mr-3" style="background-color: #B71032;"></span>
            <span class="text-sm font-bold uppercase tracking-widest text-crimson" style="font-family: 'Work Sans', sans-serif;">BREAKING FOCUS</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Hero Article (Left, wide) -->
            <div class="lg:col-span-8">
                @if($featuredArticle)
                <a href="{{ route('article', $featuredArticle->slug) }}" class="block group relative w-full h-[400px] lg:h-[500px]">
                    <!-- Check if article has featured image path -->
                    @if($featuredArticle->featured_image_path)
                        @if(Str::startsWith($featuredArticle->featured_image_path, ['http://', 'https://']))
                            <img src="{{ $featuredArticle->featured_image_path }}" class="w-full h-full object-cover" alt="{{ $featuredArticle->title }}">
                        @else
                            <img src="{{ asset('storage/' . $featuredArticle->featured_image_path) }}" class="w-full h-full object-cover" alt="{{ $featuredArticle->title }}">
                        @endif
                    @else
                        <img src="https://images.unsplash.com/photo-1581093458791-9f3c3900df4b?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Featured">
                    @endif
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#00081E] via-[#00081E]/80 to-transparent"></div>
                    
                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 p-8 w-full max-w-3xl">
                        <span class="text-sm font-bold uppercase tracking-widest text-crimson mb-3 block" style="font-family: 'Work Sans', sans-serif;">{{ $featuredArticle->category->name }}</span>
                        <h2 class="text-3xl lg:text-[32px] font-bold mb-4 text-white group-hover:text-gray-200 transition-colors" style="font-family: Montserrat, sans-serif; line-height: 1.2;">
                            {{ $featuredArticle->title }}
                        </h2>
                        <p class="text-[17px] text-[#7687B2] line-clamp-2" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                            {{ $featuredArticle->excerpt }}
                        </p>
                    </div>
                </a>
                @endif
            </div>

            <!-- Sidebar Articles (Right, narrow) -->
            <div class="lg:col-span-4 flex flex-col justify-center border-t lg:border-t-0 lg:border-l border-gray-700 pt-8 lg:pt-0 lg:pl-8">
                @foreach($recentArticles->take(2) as $index => $article)
                <div class="py-6 {{ $index === 0 ? 'border-b border-gray-700' : '' }}">
                    <a href="{{ route('article', $article->slug) }}" class="block group">
                        <span class="text-xs font-bold uppercase tracking-widest text-crimson mb-2 block" style="font-family: 'Work Sans', sans-serif;">{{ $article->category->name }}</span>
                        <h3 class="text-2xl font-bold mb-3 text-white group-hover:text-gray-200 transition-colors" style="font-family: Montserrat, sans-serif; line-height: 1.3;">
                            {{ $article->title }}
                        </h3>
                        <p class="text-sm text-[#7687B2] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                            {{ $article->excerpt }}
                        </p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- News Ticker -->
<div class="bg-crimson overflow-hidden flex items-center relative group py-2 w-full">
    <div class="flex whitespace-nowrap animate-marquee items-center text-white text-sm font-bold uppercase tracking-widest" style="font-family: 'Work Sans', sans-serif;">
        <!-- First set -->
        <div class="flex items-center px-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            CAMPUS TRANSIT DELAYS EXPECTED ON SOUTH ROUTE TODAY
        </div>
        <div class="text-white mx-2">|</div>
        <div class="flex items-center px-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            REGISTRATION FOR FALL SEMESTER OPENS NEXT TUESDAY AT 8:00 AM
        </div>
        <div class="text-white mx-2">|</div>
        <!-- Duplicate for seamless loop -->
        <div class="flex items-center px-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            CAMPUS TRANSIT DELAYS EXPECTED ON SOUTH ROUTE TODAY
        </div>
        <div class="text-white mx-2">|</div>
        <div class="flex items-center px-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            REGISTRATION FOR FALL SEMESTER OPENS NEXT TUESDAY AT 8:00 AM
        </div>
        <div class="text-white mx-2">|</div>
    </div>
</div>

<!-- Recent News Section -->
<section class="py-20 bg-background">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10">
        
        <div class="mb-8 border-b pb-4 border-[#C5C6CF]">
            <h2 class="text-[32px] font-bold text-navy" style="font-family: Montserrat, sans-serif;">
                Recent News
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-12">
            <!-- Main Grid -->
            <div>
                <div class="columns-1 sm:columns-2 gap-6 space-y-6 mb-12">
                    @foreach($recentArticles->skip(2)->take(6) as $article)
                    <a href="{{ route('article', $article->slug) }}" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid">
                        <!-- Thumbnail -->
                        <div class="w-full bg-gray-100 border-b border-[#C5C6CF]">
                            @if($article->featured_image_path)
                                @if(Str::startsWith($article->featured_image_path, ['http://', 'https://']))
                                    <img src="{{ $article->featured_image_path }}" class="w-full h-auto object-cover" alt="{{ $article->title }}">
                                @else
                                    <img src="{{ asset('storage/' . $article->featured_image_path) }}" class="w-full h-auto object-cover" alt="{{ $article->title }}">
                                @endif
                            @else
                                <img src="https://images.unsplash.com/photo-1507668077129-56e32842fceb?q=80&w=800&auto=format&fit=crop" class="w-full h-auto object-cover" alt="Article">
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center space-x-3 mb-3">
                                <span class="text-xs font-bold uppercase tracking-widest text-crimson" style="font-family: 'Work Sans', sans-serif;">{{ $article->category->name }}</span>
                                <span class="text-xs text-gray-500 font-medium" style="font-family: 'Work Sans', sans-serif;">{{ $article->published_at->format('M d') }}</span>
                            </div>
                            <h3 class="text-[18px] font-bold mb-3 group-hover:text-crimson transition-colors text-navy" style="font-family: Montserrat, sans-serif; line-height: 1.3;">
                                {{ $article->title }}
                            </h3>
                            <p class="text-[14px] text-gray-600 line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                {{ $article->excerpt }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between border-t pt-8 border-[#C5C6CF]">
                    <a href="#" class="text-sm font-bold uppercase tracking-widest flex items-center hover:opacity-80 text-[#4C5E86]" style="font-family: 'Work Sans', sans-serif;">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> NEWER
                    </a>
                    <div class="flex space-x-2" style="font-family: 'Work Sans', sans-serif;">
                        <span class="w-10 h-10 flex items-center justify-center font-bold text-sm text-white bg-navy rounded-[4px]">1</span>
                        <a href="#" class="w-10 h-10 flex items-center justify-center font-bold text-sm text-[#44464E] rounded-[4px] hover:bg-gray-100">2</a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center font-bold text-sm text-[#44464E] rounded-[4px] hover:bg-gray-100">3</a>
                        <span class="w-10 h-10 flex items-center justify-center font-bold text-sm text-[#C5C6CF]">...</span>
                        <a href="#" class="w-10 h-10 flex items-center justify-center font-bold text-sm text-[#44464E] rounded-[4px] hover:bg-gray-100">12</a>
                    </div>
                    <a href="#" class="text-sm font-bold uppercase tracking-widest flex items-center hover:opacity-80 text-navy" style="font-family: 'Work Sans', sans-serif;">
                        OLDER <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Trending News Widget -->
                <div class="bg-[#F0EDEE] rounded-[8px] p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest mb-5 flex items-center text-navy" style="font-family: Montserrat, sans-serif;">
                        <span class="w-2 h-2 rounded-full mr-3 bg-crimson"></span> TRENDING NEWS
                    </h3>
                    <div class="space-y-5">
                        
                        <div class="flex gap-4 group items-start">
                            <span class="text-3xl font-bold leading-none text-[#7687B2]" style="font-family: Montserrat, sans-serif;">01</span>
                            <div>
                                <a href="#">
                                    <h4 class="text-[15px] font-bold group-hover:text-crimson transition-colors line-clamp-2 mb-1 leading-snug text-navy" style="font-family: Montserrat, sans-serif;">
                                        Breakthrough in Quantum Computing Achieved by Engineering Faculty
                                    </h4>
                                </a>
                                <span class="text-xs font-medium uppercase tracking-wide text-[#44464E]" style="font-family: 'Work Sans', sans-serif;">Technology</span>
                            </div>
                        </div>

                        <div class="flex gap-4 group items-start">
                            <span class="text-3xl font-bold leading-none text-[#7687B2]" style="font-family: Montserrat, sans-serif;">02</span>
                            <div>
                                <a href="#">
                                    <h4 class="text-[15px] font-bold group-hover:text-crimson transition-colors line-clamp-2 mb-1 leading-snug text-navy" style="font-family: Montserrat, sans-serif;">
                                        New Study Links Urban Green Spaces to Lower Stress Levels in Students
                                    </h4>
                                </a>
                                <span class="text-xs font-medium uppercase tracking-wide text-[#44464E]" style="font-family: 'Work Sans', sans-serif;">Health & Wellness</span>
                            </div>
                        </div>

                        <div class="flex gap-4 group items-start">
                            <span class="text-3xl font-bold leading-none text-[#7687B2]" style="font-family: Montserrat, sans-serif;">03</span>
                            <div>
                                <a href="#">
                                    <h4 class="text-[15px] font-bold group-hover:text-crimson transition-colors line-clamp-2 mb-1 leading-snug text-navy" style="font-family: Montserrat, sans-serif;">
                                        Annual Arts Festival Draws Record-Breaking Crowd This Weekend
                                    </h4>
                                </a>
                                <span class="text-xs font-medium uppercase tracking-wide text-[#44464E]" style="font-family: 'Work Sans', sans-serif;">Campus Life</span>
                            </div>
                        </div>

                        <div class="flex gap-4 group items-start">
                            <span class="text-3xl font-bold leading-none text-[#7687B2]" style="font-family: Montserrat, sans-serif;">04</span>
                            <div>
                                <a href="#">
                                    <h4 class="text-[15px] font-bold group-hover:text-crimson transition-colors line-clamp-2 mb-1 leading-snug text-navy" style="font-family: Montserrat, sans-serif;">
                                        Researchers Discover Novel Enzyme that Breaks Down Microplastics
                                    </h4>
                                </a>
                                <span class="text-xs font-medium uppercase tracking-wide text-[#44464E]" style="font-family: 'Work Sans', sans-serif;">Environment</span>
                            </div>
                        </div>

                        <div class="flex gap-4 group items-start">
                            <span class="text-3xl font-bold leading-none text-[#7687B2]" style="font-family: Montserrat, sans-serif;">05</span>
                            <div>
                                <a href="#">
                                    <h4 class="text-[15px] font-bold group-hover:text-crimson transition-colors line-clamp-2 mb-1 leading-snug text-navy" style="font-family: Montserrat, sans-serif;">
                                        University Announces Groundbreaking $50M Endowment for Scholarships
                                    </h4>
                                </a>
                                <span class="text-xs font-medium uppercase tracking-wide text-[#44464E]" style="font-family: 'Work Sans', sans-serif;">Administration</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Advertisement Slot -->
                <div class="flex flex-col">
                    <h3 class="text-[12px] font-bold uppercase tracking-widest mb-3 flex items-center text-[#44464E]" style="font-family: 'Work Sans', sans-serif;">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 bg-crimson"></span> ADVERTISEMENT
                    </h3>
                    <div class="bg-[#F0EDEE] border border-[#C5C6CF] rounded-[8px] h-64 flex flex-col items-center justify-center text-[#C5C6CF]">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="text-xs font-bold tracking-widest uppercase" style="font-family: 'Work Sans', sans-serif;">SPONSOR CONTENT</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
