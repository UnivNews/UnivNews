@extends('layouts.public')

@section('title', 'Achievements - University News')

@section('content')
<main class="bg-[#FCF8F9] min-h-screen pb-20" x-data="achievementSystem()">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12">
        
        <!-- Page Header -->
        <div class="mb-12 border-b border-[#C5C6CF] pb-6">
            <h1 class="font-heading text-5xl font-bold text-[#00081E] mb-4 tracking-tight uppercase">Achievements</h1>
            <p class="font-sans text-xl text-[#44464E] max-w-3xl">Celebrating the outstanding accomplishments of our students, faculty, and researchers across academia, sports, and beyond.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Main Content (Left) -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Featured Hero Slider -->
                @if(($featuredAchievementArticles ?? collect())->count() > 0)
                <div x-data="{
                    currentSlide: 0,
                    totalSlides: {{ $featuredAchievementArticles->count() }},
                    autoplay: null,
                    startAutoplay() { this.autoplay = setInterval(() => { this.nextSlide() }, 5000); },
                    stopAutoplay() { clearInterval(this.autoplay); },
                    nextSlide() { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; },
                    goToSlide(i) { this.currentSlide = i; this.stopAutoplay(); this.startAutoplay(); }
                }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                    <div class="relative w-full h-[400px] mb-6 overflow-hidden bg-gray-100 border border-[#C5C6CF]">
                        @foreach($featuredAchievementArticles as $index => $slide)
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
                                    <img src="https://picsum.photos/seed/achieve{{ $slide->id }}/1280/720" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="Achievement">
                                @endif
                                <div class="absolute top-4 left-4 bg-[#B71032] text-white px-3 py-1 font-sans font-semibold text-xs tracking-wider uppercase">
                                    FEATURED ACHIEVEMENT
                                </div>
                            </a>
                        </div>
                        @endforeach

                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-4 z-20 flex items-center space-x-2">
                            @foreach($featuredAchievementArticles as $index => $slide)
                            <button @click="goToSlide({{ $index }})" 
                                    class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                    :class="currentSlide === {{ $index }} ? 'bg-[#B71032] w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dynamic text content under slider -->
                    @foreach($featuredAchievementArticles as $index => $slide)
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
                        { tag: 'MAJOR BREAKTHROUGH', title: 'Student Robotics Team Wins International Gold at Global Tech Symposium', desc: 'The university\'s undergraduate robotics team surpassed 40 international institutions to claim first place with their autonomous environmental monitoring drone.', image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1280&auto=format&fit=crop' },
                        { tag: 'ACADEMIC EXCELLENCE', title: 'English Debate Team Claims 1st Place at Southeast Asia Competition', desc: 'Four students achieved a brilliant victory after defeating 28 universities from 10 ASEAN countries in the international debate tournament.', image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1280&auto=format&fit=crop' },
                        { tag: 'INNOVATION AWARD', title: 'Engineering Faculty Student Patents New Waste Processing Technology', desc: 'A student innovation converting plastic waste into alternative fuel received international recognition and a full patent, making headlines worldwide.', image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=1280&auto=format&fit=crop' }
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
                                    FEATURED ACHIEVEMENT
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
                                Read More
                            </span>
                        </div>
                    </template>
                </div>
                @endif

                <hr class="border-[#C5C6CF]"/>

                <!-- Achievements Grid -->
                <div class="mb-12 min-h-[300px]">
                    <!-- Empty State -->
                    <div x-show="filteredAchievements.length === 0" class="flex flex-col items-center justify-center h-64 text-center border border-[#C5C6CF] border-dashed rounded-lg bg-gray-50" x-cloak>
                        <svg class="w-12 h-12 text-[#C5C6CF] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-[#44464E] font-medium font-sans">No achievements match your selected filters.</p>
                        <button @click="resetFilters" type="button" class="mt-4 text-[#B71032] text-sm font-bold uppercase tracking-wider hover:underline">Reset Filters</button>
                    </div>

                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6" x-show="filteredAchievements.length > 0">
                        <template x-for="item in filteredAchievements" :key="item.id">
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

                <!-- Trending Achievements -->
                <div>
                    <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-6 border-b-2 border-[#B71032] pb-2 inline-block">Top Achievements</h3>
                    <div class="space-y-6">
                        @php
                            $allPubArticles = \App\Models\Article::where('status', 'published')
                                ->whereNotNull('published_at')
                                ->where('published_at', '<=', now())
                                ->orderBy('published_at', 'desc')
                                ->get();

                            $trendingPool = $articles->concat($allPubArticles)->unique('id')->take(4);

                            if ($trendingPool->isNotEmpty()) {
                                $trendingItems = $trendingPool->map(function($a) {
                                    return [
                                        'category' => $a->tags->first() ? $a->tags->first()->name : $a->category->name,
                                        'title' => $a->title,
                                        'date' => $a->published_at ? $a->published_at->format('M d, Y') : now()->format('M d, Y'),
                                        'url' => route('article', $a->slug)
                                    ];
                                })->toArray();
                            } else {
                                $trendingItems = [
                                    ['category' => 'STUDENTS', 'title' => 'Debate Team Secures National Championship Title', 'date' => 'Nov 12, 2024', 'url' => route('home')],
                                    ['category' => 'SCIENCE', 'title' => 'Robotics Lab Wins International Gold at Tech Symposium', 'date' => 'Nov 10, 2024', 'url' => route('home')],
                                    ['category' => 'FACULTY', 'title' => 'Professor Awarded Prestigious Humanities Fellowship', 'date' => 'Nov 08, 2024', 'url' => route('home')],
                                    ['category' => 'ATHLETICS', 'title' => 'University Track Team Breaks State Relay Record', 'date' => 'Nov 05, 2024', 'url' => route('home')],
                                ];
                            }
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

                <!-- Alumni Spotlight -->
                <div class="bg-[#FCF8F9] border border-[#C5C6CF] p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest mb-5 flex items-center text-[#00081E]">
                        <span class="w-2 h-2 rounded-full mr-3 bg-[#B71032]"></span> ALUMNI SPOTLIGHT
                    </h3>
                    <div class="space-y-5">
                        <div class="relative">
                            <div class="absolute -top-2 -left-1 text-[#C5C6CF] font-serif text-6xl leading-none font-bold opacity-50">&ldquo;</div>
                            <p class="text-[15px] text-[#44464E] italic pl-6 leading-relaxed" style="font-family: 'Source Serif 4', serif;">
                                The foundation provided by the Gazette's journalism program was instrumental in my Pulitzer recognition.
                            </p>
                            <p class="text-xs font-bold text-[#00081E] mt-3 pl-6 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                &mdash; Marcus Reed, Class of '15
                            </p>
                        </div>
                        <hr class="border-[#C5C6CF]">
                        <div class="relative">
                            <div class="absolute -top-2 -left-1 text-[#C5C6CF] font-serif text-6xl leading-none font-bold opacity-50">&ldquo;</div>
                            <p class="text-[15px] text-[#44464E] italic pl-6 leading-relaxed" style="font-family: 'Source Serif 4', serif;">
                                My research at the university's AI lab laid the groundwork for our company's autonomous navigation system.
                            </p>
                            <p class="text-xs font-bold text-[#00081E] mt-3 pl-6 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                &mdash; Dr. Sarah Lin, Class of '08
                            </p>
                        </div>
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
    Alpine.data('achievementSystem', () => ({
        @php
            $dummyVariations = [
                [
                    'category' => 'Students',
                    'date' => 'Nov 15',
                    'title' => 'Robotics Lab Unveils Autonomous Campus Delivery Prototype',
                    'excerpt' => 'A team of graduate students has developed a self-navigating rover designed to deliver library books and small packages safely across pedestrian walkways.',
                    'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Faculty',
                    'date' => 'Nov 12',
                    'title' => 'Business School Launches New Venture Capital Fellowship',
                    'excerpt' => 'The fellowship will provide 20 outstanding MBA candidates with hands-on experience managing a $5 million student-run investment fund.',
                    'image' => 'https://images.unsplash.com/photo-1542744094-24638eff58bb?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Science',
                    'date' => 'Nov 10',
                    'title' => 'New Study Links Urban Green Spaces to Lower Stress Levels in Students',
                    'excerpt' => 'Researchers found a significant correlation between time spent in campus parks and reduced cortisol levels during finals week.',
                    'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Athletics',
                    'date' => 'Nov 08',
                    'title' => 'University Track Team Breaks State Relay Record',
                    'excerpt' => 'The 4x100m relay team set a new state record this weekend, qualifying for the national championships.',
                    'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Students',
                    'date' => 'Nov 05',
                    'title' => 'Debate Team Secures National Championship Title',
                    'excerpt' => 'After a grueling three-day tournament, the university debate society brought home the national trophy.',
                    'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop',
                ],
                [
                    'category' => 'Faculty',
                    'date' => 'Nov 02',
                    'title' => 'Professor Awarded Prestigious Humanities Fellowship',
                    'excerpt' => 'Dr. Elena Rostova has been granted a two-year fellowship to complete her research on pre-colonial trade routes.',
                    'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=600&auto=format&fit=crop',
                ],
            ];
            $dummyCount = max(0, 9 - $articles->count());
            $anyArticle = \App\Models\Article::where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())->first();
            $fallbackUrl = $anyArticle ? route('article', $anyArticle->slug) : route('home');
        @endphp
        allAchievements: [
            @foreach($articles as $article)
            {
                id: 'db_{{ $article->id }}',
                title: @json($article->title),
                category: @json($article->tags->first() ? $article->tags->first()->name : $article->category->name),
                date: @json($article->published_at->format('M d')),
                excerpt: @json($article->excerpt),
                image: @json($article->featured_image_path ? (Str::startsWith($article->featured_image_path, ['http://', 'https://']) ? $article->featured_image_path : asset('storage/' . $article->featured_image_path)) : 'https://picsum.photos/seed/achieve' . $article->id . '/800/533'),
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
                excerpt: @json($variation['excerpt']),
                image: @json($variation['image']),
                url: @json($fallbackUrl),
            },
            @endfor
        ],

        get filteredAchievements() {
            return this.allAchievements;
        },

        resetFilters() {}
    }));
});
</script>
@endsection
