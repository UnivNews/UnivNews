@extends('layouts.public')

@section('title', 'University News - Home')

@section('content')

<style>
    .ticker-wrap {
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
    }
    .ticker-track {
        display: inline-flex;
        animation: scroll-left 25s linear infinite;
        will-change: transform;
    }
    .ticker-track:hover {
        animation-play-state: paused;
    }
    .ticker-content {
        display: flex;
        align-items: center;
    }
    @keyframes scroll-left {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
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
            <!-- Hero Slider (Left, wide) -->
            <div class="lg:col-span-8" x-data="{ 
                currentSlide: 0, 
                totalSlides: {{ $featuredArticles->count() }},
                autoplay: null,
                startAutoplay() {
                    this.autoplay = setInterval(() => { this.nextSlide() }, 5000);
                },
                stopAutoplay() {
                    clearInterval(this.autoplay);
                },
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                },
                prevSlide() {
                    this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                },
                goToSlide(i) {
                    this.currentSlide = i;
                    this.stopAutoplay();
                    this.startAutoplay();
                }
            }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                <div class="relative w-full h-[400px] lg:h-[500px] overflow-hidden">
                    @foreach($featuredArticles as $index => $slide)
                    <a href="{{ route('article', $slide->slug) }}" 
                       class="absolute inset-0 block group transition-opacity duration-700 ease-in-out"
                       :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                       @if($index !== 0) x-cloak @endif>
                        @if($slide->featured_image_path)
                            @if(Str::startsWith($slide->featured_image_path, ['http://', 'https://']))
                                <img src="{{ $slide->featured_image_path }}" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="{{ $slide->title }}">
                            @else
                                <img src="{{ asset('storage/' . $slide->featured_image_path) }}" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="{{ $slide->title }}">
                            @endif
                        @else
                            <img src="https://picsum.photos/seed/hero{{ $slide->id }}/1280/720" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="Featured">
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#00081E] via-[#00081E]/80 to-transparent"></div>
                        
                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 p-8 w-full max-w-3xl">
                            <span class="text-sm font-bold uppercase tracking-widest text-crimson mb-3 block" style="font-family: 'Work Sans', sans-serif;">{{ $slide->category->name }}</span>
                            <h2 class="text-3xl lg:text-[32px] font-bold mb-4 text-white" style="font-family: Montserrat, sans-serif; line-height: 1.2;">
                                {{ $slide->title }}
                            </h2>
                            <p class="text-[17px] text-[#7687B2] line-clamp-2" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                {{ $slide->excerpt }}
                            </p>
                        </div>
                    </a>
                    @endforeach

                    <!-- Slide Indicators -->
                    <div class="absolute bottom-4 right-4 z-20 flex items-center space-x-2">
                        @foreach($featuredArticles as $index => $slide)
                        <button @click="goToSlide({{ $index }})" 
                                class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                :class="currentSlide === {{ $index }} ? 'bg-crimson w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows (Desktop only to prevent mobile text overlap) -->
                    <button @click="prevSlide(); stopAutoplay(); startAutoplay();" class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-crimson text-white w-10 h-10 items-center justify-center transition-colors backdrop-blur-sm opacity-0 group-hover:opacity-100" style="opacity: 0.7;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="nextSlide(); stopAutoplay(); startAutoplay();" class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-crimson text-white w-10 h-10 items-center justify-center transition-colors backdrop-blur-sm opacity-0 group-hover:opacity-100" style="opacity: 0.7;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
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
<div class="bg-crimson ticker-wrap py-2">
    <div class="ticker-track">
        <!-- Content 1 -->
        <div class="ticker-content text-white text-sm font-bold uppercase tracking-widest" style="font-family: 'Work Sans', sans-serif;">
            @for($i = 0; $i < 6; $i++)
                @foreach($marqueeArticles as $article)
                <a href="{{ route('article', $article->slug) }}" class="flex items-center px-4 hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ $article->title }}
                </a>
                <div class="text-white mx-2">|</div>
                @endforeach
            @endfor
        </div>
        <!-- Content 2 -->
        <div class="ticker-content text-white text-sm font-bold uppercase tracking-widest" style="font-family: 'Work Sans', sans-serif;" aria-hidden="true">
            @for($i = 0; $i < 6; $i++)
                @foreach($marqueeArticles as $article)
                <a href="{{ route('article', $article->slug) }}" class="flex items-center px-4 hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ $article->title }}
                </a>
                <div class="text-white mx-2">|</div>
                @endforeach
            @endfor
        </div>
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
                <div class="mb-12">
                    <!-- Recent News Grid -->
                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6">
                        @php
                            $recentList = $recentArticles->skip(2)->take(6);
                            $recentDummyCount = 6 - $recentList->count();
                            
                            $dummyVariations = [
                                [
                                    'category' => 'RESEARCH & INNOVATION',
                                    'date' => 'Nov 15',
                                    'title' => 'Robotics Lab Unveils Autonomous Campus Delivery Prototype',
                                    'excerpt' => 'A team of graduate students has developed a self-navigating rover designed to deliver library books and small packages safely across pedestrian walkways.',
                                    'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=600&auto=format&fit=crop'
                                ],
                                [
                                    'category' => 'ACHIEVEMENTS',
                                    'date' => 'Nov 12',
                                    'title' => 'Business School Launches New Venture Capital Fellowship',
                                    'excerpt' => 'The fellowship will provide 20 outstanding MBA candidates with hands-on experience managing a $5 million student-run investment fund.',
                                    'image' => 'https://images.unsplash.com/photo-1542744094-24638eff58bb?q=80&w=600&auto=format&fit=crop'
                                ],
                                [
                                    'category' => 'RESEARCH & INNOVATION',
                                    'date' => 'Nov 10',
                                    'title' => 'New Study Links Urban Green Spaces to Lower Stress Levels in Students',
                                    'excerpt' => 'Researchers found a significant correlation between time spent in campus parks and reduced cortisol levels during finals week.',
                                    'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop'
                                ],
                                [
                                    'category' => 'EVENTS',
                                    'date' => 'Nov 08',
                                    'title' => 'Annual Arts Festival Draws Record-Breaking Crowd This Weekend',
                                    'excerpt' => 'Over 10,000 students and local residents attended the three-day event featuring live music, student films, and interactive installations.',
                                    'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=600&auto=format&fit=crop'
                                ],
                                [
                                    'category' => 'EVENTS',
                                    'date' => 'Nov 05',
                                    'title' => 'Researchers Discover Novel Enzyme that Breaks Down Microplastics',
                                    'excerpt' => 'A cross-disciplinary team from Biology and Chemistry has isolated a bacteria strain capable of digesting common packaging materials.',
                                    'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=600&auto=format&fit=crop'
                                ],
                                [
                                    'category' => 'ACHIEVEMENTS',
                                    'date' => 'Nov 02',
                                    'title' => 'Varsity Basketball Team Secures Regional Championship',
                                    'excerpt' => 'A thrilling overtime victory propels the team to the national tournament while breaking several school records.',
                                    'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=600&auto=format&fit=crop'
                                ]
                            ];
                        @endphp

                        @foreach($recentList as $article)
                        <a href="{{ route('article', $article->slug) }}" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid mb-6">
                            <!-- Thumbnail -->
                            <div class="w-full bg-gray-100 border-b border-[#C5C6CF] overflow-hidden">
                                @if($article->featured_image_path)
                                    @if(Str::startsWith($article->featured_image_path, ['http://', 'https://']))
                                        <img src="{{ $article->featured_image_path }}" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $article->title }}">
                                    @else
                                        <img src="{{ asset('storage/' . $article->featured_image_path) }}" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $article->title }}">
                                    @endif
                                @else
                                    <img src="https://picsum.photos/seed/fallback/800/533" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="Article">
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

                        @for($i = 0; $i < $recentDummyCount; $i++)
                        @php $variation = $dummyVariations[$i % count($dummyVariations)]; @endphp
                        <a href="#" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid mb-6">
                            <div class="w-full bg-gray-100 border-b border-[#C5C6CF] overflow-hidden">
                                <img src="{{ $variation['image'] }}" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $variation['title'] }}">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-crimson" style="font-family: 'Work Sans', sans-serif;">{{ $variation['category'] }}</span>
                                    <span class="text-xs text-gray-500 font-medium" style="font-family: 'Work Sans', sans-serif;">{{ $variation['date'] }}</span>
                                </div>
                                <h3 class="text-[18px] font-bold mb-3 group-hover:text-crimson transition-colors text-navy" style="font-family: Montserrat, sans-serif; line-height: 1.3;">
                                    {{ $variation['title'] }}
                                </h3>
                                <p class="text-[14px] text-gray-600 line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                    {{ $variation['excerpt'] }}
                                </p>
                            </div>
                        </a>
                        @endfor
                    </div>
                </div>

                <!-- Others Section Header -->
                <div class="mb-8 border-b pb-4 border-[#C5C6CF] mt-16">
                    <h2 class="text-[32px] font-bold text-navy" style="font-family: Montserrat, sans-serif;">
                        Others
                    </h2>
                </div>

                <div class="mb-12">
                    <!-- Others Grid (15 items) -->
                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6">
                        @php
                            $otherArticles = $recentArticles->skip(8)->take(15);
                            $dummyCount = 15 - $otherArticles->count();
                        @endphp

                        @foreach($otherArticles as $article)
                        <a href="{{ route('article', $article->slug) }}" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid mb-6">
                            <!-- Thumbnail -->
                            <div class="w-full bg-gray-100 border-b border-[#C5C6CF] overflow-hidden">
                                @if($article->featured_image_path)
                                    @if(Str::startsWith($article->featured_image_path, ['http://', 'https://']))
                                        <img src="{{ $article->featured_image_path }}" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $article->title }}">
                                    @else
                                        <img src="{{ asset('storage/' . $article->featured_image_path) }}" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $article->title }}">
                                    @endif
                                @else
                                    <img src="https://picsum.photos/seed/fallback/800/533" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="Article">
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

                        @for($i = 0; $i < $dummyCount; $i++)
                        @php $variation = $dummyVariations[$i % count($dummyVariations)]; @endphp
                        <!-- Dummy Card -->
                        <a href="#" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid mb-6">
                            <div class="w-full bg-gray-100 border-b border-[#C5C6CF] overflow-hidden">
                                <img src="{{ $variation['image'] }}" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $variation['title'] }}">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-crimson" style="font-family: 'Work Sans', sans-serif;">{{ $variation['category'] }}</span>
                                    <span class="text-xs text-gray-500 font-medium" style="font-family: 'Work Sans', sans-serif;">{{ $variation['date'] }}</span>
                                </div>
                                <h3 class="text-[18px] font-bold mb-3 group-hover:text-crimson transition-colors text-navy" style="font-family: Montserrat, sans-serif; line-height: 1.3;">
                                    {{ $variation['title'] }}
                                </h3>
                                <p class="text-[14px] text-gray-600 line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                    {{ $variation['excerpt'] }}
                                </p>
                            </div>
                        </a>
                        @endfor
                    </div>
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
