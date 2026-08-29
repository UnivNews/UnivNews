@extends('layouts.public')

@section('title', 'Events - University News')

@section('content')
<main class="bg-[#FCF8F9] min-h-screen pb-20" x-data="eventSystem()">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12">
        
        <!-- Page Header -->
        <div class="mb-12 border-b border-[#C5C6CF] pb-6">
            <h1 class="font-heading text-5xl font-bold text-[#00081E] mb-4 tracking-tight uppercase">Events</h1>
            <p class="font-sans text-xl text-[#44464E] max-w-3xl">Stay up to date with the latest seminars, competitions, performances, and community gatherings happening across campus.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Main Content (Left) -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Featured Hero Slider -->
                @if(($featuredEventArticles ?? collect())->count() > 0)
                <div x-data="{
                    currentSlide: 0,
                    totalSlides: {{ $featuredEventArticles->count() }},
                    autoplay: null,
                    startAutoplay() { this.autoplay = setInterval(() => { this.nextSlide() }, 5000); },
                    stopAutoplay() { clearInterval(this.autoplay); },
                    nextSlide() { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; },
                    goToSlide(i) { this.currentSlide = i; this.stopAutoplay(); this.startAutoplay(); }
                }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                    <div class="relative w-full h-[400px] mb-6 overflow-hidden bg-gray-100 border border-[#C5C6CF]">
                        @foreach($featuredEventArticles as $index => $slide)
                        <div class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                             :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                             @if($index !== 0) x-cloak @endif>
                            <a href="{{ route('article', $slide->slug) }}" class="block w-full h-full group">
                                @if($slide->featured_image_path)
                                    @if(Str::startsWith($slide->featured_image_path, ['http://', 'https://']))
                                        <img src="{{ $slide->featured_image_path }}" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="{{ $slide->title }}">
                                    @else
                                        <img src="{{ asset('storage/' . $slide->featured_image_path) }}" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="{{ $slide->title }}">
                                    @endif
                                @else
                                    <img src="https://picsum.photos/seed/event{{ $slide->id }}/1280/720" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="Event">
                                @endif
                                <div class="absolute top-4 left-4 bg-[#B71032] text-white px-3 py-1 font-sans font-semibold text-xs tracking-wider uppercase">
                                    FEATURED EVENT
                                </div>
                            </a>
                        </div>
                        @endforeach

                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-4 z-20 flex items-center space-x-2">
                            @foreach($featuredEventArticles as $index => $slide)
                            <button @click="goToSlide({{ $index }})" 
                                    class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                    :class="currentSlide === {{ $index }} ? 'bg-[#B71032] w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dynamic text content under slider -->
                    @foreach($featuredEventArticles as $index => $slide)
                    <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" @if($index !== 0) x-cloak @endif>
                        <h2 class="font-heading font-semibold text-[32px] leading-tight text-[#00081E] mb-4 hover:text-[#B71032] transition-colors">
                            <a href="{{ route('article', $slide->slug) }}">{{ $slide->title }}</a>
                        </h2>
                        <p class="font-body text-[17px] leading-[28px] text-[#44464E] mb-6 line-clamp-3">
                            {{ $slide->excerpt }}
                        </p>
                        <a href="{{ route('article', $slide->slug) }}" class="inline-block font-sans font-semibold text-sm text-[#00081E] border border-[#00081E] px-6 py-3 hover:bg-[#00081E] hover:text-white transition-colors uppercase tracking-wider">
                            Read More
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <!-- Alpine Slider Fallback (no DB articles) -->
                <div x-data="{
                    currentSlide: 0,
                    slides: [
                        { tag: 'ARTS & CULTURE', title: 'University Symphony Orchestra Autumn Concert', desc: 'A special performance featuring classical and contemporary works by students of the performing arts faculty that drew over 3,000 attendees.', image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1280&auto=format&fit=crop' },
                        { tag: 'SEMINAR', title: 'National Seminar: Facing the Society 5.0 Era', desc: 'Panel discussion with leading technology experts and academics discussing the challenges and opportunities in the era of Society 5.0.', image: 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=1280&auto=format&fit=crop' },
                        { tag: 'SPORTS', title: 'Inter-Faculty Football Tournament – Rector Cup 2024', desc: 'The biggest inter-faculty sports competition of the semester, featuring 16 teams competing for the prestigious Rector Cup trophy.', image: 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=1280&auto=format&fit=crop' }
                    ],
                    autoplay: null,
                    startAutoplay() { this.autoplay = setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.slides.length; }, 5000); },
                    stopAutoplay() { clearInterval(this.autoplay); },
                    goToSlide(i) { this.currentSlide = i; this.stopAutoplay(); this.startAutoplay(); }
                }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                    <div class="relative w-full h-[400px] mb-6 overflow-hidden bg-gray-100 border border-[#C5C6CF]">
                        <template x-for="(slide, idx) in slides" :key="idx">
                            <div class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                                 :class="currentSlide === idx ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                <img :src="slide.image" :alt="slide.tag" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === idx ? 'scale-105' : 'scale-100'">
                                <div class="absolute top-4 left-4 bg-[#B71032] text-white px-3 py-1 font-sans font-semibold text-xs tracking-wider uppercase">
                                    FEATURED EVENT
                                </div>
                            </div>
                        </template>

                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-4 z-20 flex items-center space-x-2">
                            <template x-for="(slide, idx) in slides" :key="'dot-'+idx">
                                <button @click="goToSlide(idx)"
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                        :class="currentSlide === idx ? 'bg-[#B71032] w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                            </template>
                        </div>
                    </div>

                    <!-- Dynamic text under slider -->
                    <template x-for="(slide, idx) in slides" :key="'text-'+idx">
                        <div x-show="currentSlide === idx" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="text-[#B71032] font-sans font-bold text-sm uppercase tracking-wider mb-3" x-text="slide.tag"></div>
                            <h2 class="font-heading font-semibold text-[32px] leading-tight text-[#00081E] mb-4 hover:text-[#B71032] transition-colors" x-text="slide.title"></h2>
                            <p class="font-body text-[17px] leading-[28px] text-[#44464E] mb-6 line-clamp-3" x-text="slide.desc"></p>
                            <span class="inline-block font-sans font-semibold text-sm text-[#00081E] border border-[#00081E] px-6 py-3 hover:bg-[#00081E] hover:text-white transition-colors uppercase tracking-wider cursor-default">
                                Coming Soon
                            </span>
                        </div>
                    </template>
                </div>
                @endif

                <hr class="border-[#C5C6CF]"/>

                <!-- Events Grid -->
                <div class="mb-12 min-h-[300px]">
                    <!-- Empty State -->
                    <div x-show="filteredEvents.length === 0" class="flex flex-col items-center justify-center h-64 text-center border border-[#C5C6CF] border-dashed rounded-lg bg-gray-50" x-cloak>
                        <svg class="w-12 h-12 text-[#C5C6CF] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-[#44464E] font-medium font-sans">No events match your selected filters.</p>
                        <button @click="resetFilters" type="button" class="mt-4 text-[#B71032] text-sm font-bold uppercase tracking-wider hover:underline">Reset Filters</button>
                    </div>

                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6" x-show="filteredEvents.length > 0">
                        <template x-for="item in filteredEvents" :key="item.id">
                            <a :href="item.url" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid mb-6 relative">
                                <div class="w-full bg-gray-100 border-b border-[#C5C6CF] overflow-hidden">
                                    <img :src="item.image" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" :alt="item.title">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-widest text-crimson" style="font-family: 'Work Sans', sans-serif;" x-text="item.category"></span>
                                        <span class="text-xs text-gray-500 font-medium" style="font-family: 'Work Sans', sans-serif;" x-text="item.date"></span>
                                    </div>
                                    <h3 class="text-[18px] font-bold mb-3 group-hover:text-crimson transition-colors text-navy" style="font-family: Montserrat, sans-serif; line-height: 1.3;" x-text="item.title"></h3>
                                    <p class="text-[14px] text-gray-600 line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;" x-text="item.excerpt"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <aside class="lg:col-span-4 space-y-10">
                <!-- Calendar Widget -->
                <div class="bg-[#F0EDEE] p-6 border border-[#C5C6CF]">
                    <div class="mb-6 border-b border-[#C5C6CF] pb-2">
                        <h4 class="font-heading font-bold text-[22px] text-[#00081E]">Calendar</h4>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center mb-2">
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">Mo</div>
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">Tu</div>
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">We</div>
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">Th</div>
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">Fr</div>
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">Sa</div>
                        <div class="text-xs font-medium text-[#C5C6CF] py-1">Su</div>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center text-sm font-sans font-medium text-[#44464E]">
                        <!-- Empty slots for previous month -->
                        <div class="py-1 text-gray-300">28</div>
                        <div class="py-1 text-gray-300">29</div>
                        <div class="py-1 text-gray-300">30</div>
                        <div class="py-1 text-gray-300">31</div>
                        
                        <!-- Current month -->
                        <template x-for="day in 30" :key="day">
                            <div @click="toggleDate(day)" 
                                 class="py-1 cursor-pointer rounded transition-colors"
                                 :class="{
                                     'bg-[#B71032] text-white shadow-sm font-bold': activeFilter.date === day,
                                     'border border-[#B71032] text-[#B71032] font-bold': hasEventOnDay(day) && activeFilter.date !== day,
                                     'hover:bg-gray-200 text-[#44464E]': !hasEventOnDay(day) && activeFilter.date !== day
                                 }"
                                 x-text="day">
                            </div>
                        </template>

                        <!-- Next month -->
                        <div class="py-1 text-gray-300">1</div>
                    </div>
                </div>

                <!-- Filter Widget -->
                <div class="bg-[#FCF8F9] border border-[#C5C6CF] p-6">
                    <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-4 border-b-2 border-[#B71032] pb-2 inline-block">Filter Events</h3>
                    <form class="space-y-4 mt-4" @submit.prevent="applyFilters">
                        <div>
                            <label class="block font-sans font-semibold text-sm text-[#44464E] mb-2">Event Type</label>
                            <select x-model="form.category" class="w-full border-[#C5C6CF] bg-white text-[#00081E] font-body text-[17px] focus:border-[#B71032] focus:ring-0 rounded-none">
                                <option value="All">All Types</option>
                                <option value="Events">Campus Events</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Sports">Sports</option>
                                <option value="Arts & Culture">Arts & Culture</option>
                                <option value="Academic">Academic</option>
                                <option value="Community">Community</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-[#00081E] text-white font-sans font-semibold text-sm py-3 hover:bg-gray-800 transition-colors uppercase tracking-wider mt-2">
                            Apply Filters
                        </button>
                        <template x-if="activeFilter.category !== 'All'">
                            <button type="button" @click="resetFilters" class="w-full border border-gray-300 text-gray-600 font-sans font-semibold text-sm py-2.5 hover:bg-gray-100 transition-colors uppercase tracking-wider">
                                Reset Filters
                            </button>
                        </template>
                    </form>
                </div>

                <!-- Events Highlights (Stats) -->
                <div class="bg-[#00081E] text-white p-8 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 opacity-10 transform rotate-12 group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-heading font-semibold text-2xl mb-6 relative z-10 border-b border-white/20 pb-2">Events This Semester</h3>
                    <ul class="space-y-4 relative z-10">
                        <li class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <div class="font-heading font-bold text-2xl">120+</div>
                                <div class="font-sans text-xs text-gray-300 uppercase tracking-wider">Events Held</div>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <div>
                                <div class="font-heading font-bold text-2xl">25,000+</div>
                                <div class="font-sans text-xs text-gray-300 uppercase tracking-wider">Total Attendees</div>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <div class="font-heading font-bold text-2xl">18</div>
                                <div class="font-sans text-xs text-gray-300 uppercase tracking-wider">International Guests</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Trending Events -->
                <div>
                    <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-6 border-b-2 border-[#B71032] pb-2 inline-block">Trending Events</h3>
                    <div class="space-y-6">
                        @php
                            $trendingItems = $articles->count() >= 4 ? $articles->take(4)->map(function($a) {
                                return [
                                    'category' => $a->tags->first() ? $a->tags->first()->name : $a->category->name,
                                    'title' => $a->title,
                                    'date' => $a->published_at->format('M d, Y'),
                                    'url' => route('article', $a->slug)
                                ];
                            })->toArray() : [
                                ['category' => 'SEMINAR', 'title' => 'National Seminar: Facing the Society 5.0 Era', 'date' => 'Nov 15, 2024', 'url' => '#'],
                                ['category' => 'SPORTS', 'title' => 'Inter-Faculty Basketball Championship Finals', 'date' => 'Nov 12, 2024', 'url' => '#'],
                                ['category' => 'ARTS', 'title' => 'Annual Arts Festival Draws Record-Breaking Crowd', 'date' => 'Nov 10, 2024', 'url' => '#'],
                                ['category' => 'ACADEMIC', 'title' => 'Workshop on Writing Scopus-Indexed Research Papers', 'date' => 'Nov 08, 2024', 'url' => '#'],
                            ];
                        @endphp
                        @foreach($trendingItems as $item)
                        <a class="group block border-l-[3px] border-transparent hover:border-[#B71032] pl-4 transition-all" href="{{ $item['url'] }}">
                            <div class="text-[#B71032] font-sans font-semibold text-xs uppercase tracking-wider mb-1 flex items-center gap-2">
                                <span>{{ $item['category'] }}</span>
                                <span class="text-gray-400 text-[10px]">&bull;</span>
                                <span class="text-gray-500">{{ $item['date'] }}</span>
                            </div>
                            <h4 class="font-body text-[17px] font-bold text-[#00081E] group-hover:text-[#B71032] transition-colors leading-tight">{{ $item['title'] }}</h4>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Ad Slot -->
                <div class="bg-gray-100 border border-[#C5C6CF] p-4 text-center">
                    <div class="font-sans text-xs text-[#44464E] uppercase tracking-widest mb-2">Sponsor Content</div>
                    <div class="bg-white h-[250px] flex flex-col items-center justify-center p-6 border border-[#C5C6CF]">
                        <svg class="w-10 h-10 text-[#00081E] mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <h4 class="font-heading font-semibold text-2xl text-[#00081E] mb-2">TechCorp Innovates</h4>
                        <p class="font-sans text-xs text-[#44464E]">Partnering with leading minds to build tomorrow's infrastructure.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('eventSystem', () => ({
        @php
            $dummyVariations = [
                [
                    'category' => 'Seminar',
                    'date' => 'Nov 22',
                    'title' => 'National Seminar: Facing the Society 5.0 Era',
                    'excerpt' => 'Panel discussion with leading technology experts and academics discussing the challenges and opportunities of Society 5.0.',
                    'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Sports',
                    'date' => 'Nov 20',
                    'title' => 'Inter-Faculty Basketball Championship Finals',
                    'excerpt' => 'The most anticipated sporting event of the semester, featuring the top four faculty teams competing for the coveted Rector Cup.',
                    'image' => 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Arts & Culture',
                    'date' => 'Nov 18',
                    'title' => 'Architecture Faculty Final Year Exhibition 2024',
                    'excerpt' => 'Graduating students present their capstone design projects exploring sustainable urban living and future city planning.',
                    'image' => 'https://images.unsplash.com/photo-1517502884422-41eaead166d4?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Academic',
                    'date' => 'Nov 12',
                    'title' => 'Workshop on Writing Scopus-Indexed Research Papers',
                    'excerpt' => 'A hands-on workshop designed to help faculty and graduate students successfully publish in international indexed journals.',
                    'image' => 'https://picsum.photos/seed/event6/600/400',
                ],
                [
                    'category' => 'Community',
                    'date' => 'Nov 05',
                    'title' => 'Student Community Service at Partner Village',
                    'excerpt' => 'Hundreds of students join hands for a two-day community service program providing health checks and educational workshops.',
                    'image' => 'https://picsum.photos/seed/event7/600/400',
                ],
                [
                    'category' => 'Arts & Culture',
                    'date' => 'Nov 15',
                    'title' => 'University Symphony Orchestra Autumn Concert',
                    'excerpt' => 'A special performance featuring classical and contemporary works by students of the performing arts faculty.',
                    'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600&auto=format&fit=crop',
                ],
            ];
            $dummyCount = max(0, 9 - $articles->count());
            $anyArticle = \App\Models\Article::where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())->first();
            $fallbackUrl = $anyArticle ? route('article', $anyArticle->slug) : route('home');
        @endphp
        allEvents: [
            @foreach($articles as $article)
            {
                id: 'db_{{ $article->id }}',
                title: @json($article->title),
                category: @json($article->event_type ?: ($article->tags->first() ? $article->tags->first()->name : $article->category->name)),
                date: @json($article->published_at->format('M d')),
                day: @json((int)$article->published_at->format('j')),
                month: @json($article->published_at->format('M')),
                excerpt: @json($article->excerpt),
                image: @json($article->featured_image_path ? (Str::startsWith($article->featured_image_path, ['http://', 'https://']) ? $article->featured_image_path : asset('storage/' . $article->featured_image_path)) : 'https://picsum.photos/seed/event' . $article->id . '/800/533'),
                url: @json(route('article', $article->slug)),
            },
            @endforeach
            @for($i = 0; $i < $dummyCount; $i++)
            @php $variation = $dummyVariations[$i % count($dummyVariations)]; @endphp
            {
                id: 'dummy_{{ $i }}',
                title: @json($variation['title']),
                category: @json($variation['category']),
                date: @json($variation['date']),
                day: parseInt(@json($variation['date']).split(' ')[1]),
                month: @json($variation['date']).split(' ')[0],
                excerpt: @json($variation['excerpt']),
                image: @json($variation['image']),
                url: @json($fallbackUrl),
            },
            @endfor
        ],

        get filteredEvents() {
            return this.allEvents.filter(item => {
                let matchesCategory = this.activeFilter.category === 'All' ? true : item.category === this.activeFilter.category;
                let matchesDate = this.activeFilter.date === null ? true : item.day === this.activeFilter.date;
                return matchesCategory && matchesDate;
            });
        },

        toggleDate(day) {
            this.activeFilter.date = this.activeFilter.date === day ? null : day;
        },

        hasEventOnDay(day) {
            return this.allEvents.some(event => event.day === day);
        },

        applyFilters() {
            this.activeFilter.category = this.form.category;
        },

        resetFilters() {
            this.form.category = 'All';
            this.activeFilter.category = 'All';
            this.activeFilter.date = null;
        },
        form: {
            category: 'All',
        },
        activeFilter: {
            category: 'All',
            date: null,
        },
    }));
});
</script>
@endsection
