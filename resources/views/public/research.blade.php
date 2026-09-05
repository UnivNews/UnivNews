@extends('layouts.public')

@section('content')
<div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12 min-h-screen" x-data="researchSystem()">
    <div class="mb-12 border-b border-[#C5C6CF] pb-6">
        <h1 class="font-heading text-5xl font-bold text-[#00081E] mb-4 tracking-tight uppercase">Research & Innovation</h1>
        <p class="font-sans text-xl text-[#44464E] max-w-3xl">Exploring the frontiers of knowledge and technology to address global challenges and shape the future of society.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content (Left) -->
        <div class="lg:col-span-8 space-y-12">
            <!-- Featured Hero Slider -->
            @if(($featuredResearchArticles ?? collect())->count() > 0)
            <div x-data="{
                currentSlide: 0,
                totalSlides: {{ $featuredResearchArticles->count() }},
                autoplay: null,
                startAutoplay() { this.autoplay = setInterval(() => { this.nextSlide() }, 5000); },
                stopAutoplay() { clearInterval(this.autoplay); },
                nextSlide() { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; },
                goToSlide(i) { this.currentSlide = i; this.stopAutoplay(); this.startAutoplay(); }
            }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                <div class="relative w-full h-[400px] mb-6 overflow-hidden bg-gray-100 border border-[#C5C6CF]">
                    @foreach($featuredResearchArticles as $index => $slide)
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
                                <img src="https://picsum.photos/seed/research{{ $slide->id }}/1280/720" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === {{ $index }} ? 'scale-105' : 'scale-100'" alt="Research">
                            @endif
                            <div class="absolute top-4 left-4 bg-[#B71032] text-white px-3 py-1 font-sans font-semibold text-xs tracking-wider uppercase">
                                ACADEMIC BREAKTHROUGH
                            </div>
                        </a>
                    </div>
                    @endforeach

                    <!-- Slide Indicators -->
                    <div class="absolute bottom-4 left-4 z-20 flex items-center space-x-2">
                        @foreach($featuredResearchArticles as $index => $slide)
                        <button @click="goToSlide({{ $index }})" 
                                class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                :class="currentSlide === {{ $index }} ? 'bg-[#B71032] w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                        @endforeach
                    </div>
                </div>

                <!-- Dynamic text content under slider -->
                @foreach($featuredResearchArticles as $index => $slide)
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
            <!-- Static fallback if no DB data -->
            <article class="group cursor-pointer">
                <div class="relative w-full h-[400px] mb-6 overflow-hidden bg-gray-100 border border-[#C5C6CF]">
                    <img alt="Featured Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfg3t7NFKq4NmDP4lDCYPRZx3WQ8gSFSHj-oUFb4DvBvzTMd_FYnyG5NnFljmuENjsLuQSfe_kd_uPywkloyFKa8B3qjfOAQn_ldve0GSmJ83X2xetsCkd3nBLamQEj6E4jfuOPOoS_nk8V21MAzwju3IzqBoklME8dwOr50HPaEEbhG1CGGvM7WFzH_uSd3ws1rEWHDWgTvj0qdLw9NcRh9fAS9_NISw0r0-Z9uQEF4W5CBMLHKo9"/>
                    <div class="absolute top-4 left-4 bg-[#B71032] text-white px-3 py-1 font-sans font-semibold text-xs tracking-wider uppercase">
                        ACADEMIC BREAKTHROUGH
                    </div>
                </div>
                <div>
                    <h2 class="font-heading font-semibold text-[32px] leading-tight text-[#00081E] mb-4 group-hover:text-[#B71032] transition-colors">
                        Advanced Renewable Energy Catalyst Discovery
                    </h2>
                    <p class="font-body text-[17px] leading-[28px] text-[#44464E] mb-6 line-clamp-3">
                        Researchers at the University's Energy Institute have developed a novel catalytic process that significantly increases the efficiency of solar-to-hydrogen energy conversion, paving the way for scalable clean energy solutions.
                    </p>
                    <button class="inline-block font-sans font-semibold text-sm text-[#00081E] border border-[#00081E] px-6 py-3 hover:bg-[#00081E] hover:text-white transition-colors uppercase tracking-wider">
                        Read More
                    </button>
                </div>
            </article>
            @endif

            <hr class="border-[#C5C6CF]"/>

            <!-- Research Grid -->
            <div class="mb-12 min-h-[300px]">
                <!-- Empty State -->
                <div x-show="filteredResearch.length === 0" class="flex flex-col items-center justify-center h-64 text-center border border-[#C5C6CF] border-dashed rounded-lg bg-gray-50" x-cloak>
                    <svg class="w-12 h-12 text-[#C5C6CF] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-[#44464E] font-medium font-sans">No research matches your selected filters.</p>
                    <button @click="resetFilters" type="button" class="mt-4 text-[#B71032] text-sm font-bold uppercase tracking-wider hover:underline">Reset Filters</button>
                </div>

                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6" x-show="filteredResearch.length > 0">
                    <template x-for="item in filteredResearch" :key="item.id">
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
            <!-- Filter Widget -->
            <div class="bg-[#FCF8F9] border border-[#C5C6CF] p-6">
                <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-4 border-b-2 border-[#B71032] pb-2 inline-block">Filter Research</h3>
                <form class="space-y-4" @submit.prevent="applyFilters">
                    <div>
                        <label class="block font-sans font-semibold text-sm text-[#44464E] mb-2">Research Field</label>
                        <select x-model="form.field" class="w-full border-[#C5C6CF] bg-white text-[#00081E] font-body text-[17px] focus:border-[#B71032] focus:ring-0 rounded-none">
                            <option value="All Fields">All Fields</option>
                            <option value="Biomedical Sciences">Biomedical Sciences</option>
                            <option value="Engineering & Applied Science">Engineering & Applied Science</option>
                            <option value="Social Sciences & Humanities">Social Sciences & Humanities</option>
                            <option value="Computer Science & AI">Computer Science & AI</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-sans font-semibold text-sm text-[#44464E] mb-2">Research Center/Lab</label>
                        <select x-model="form.center" class="w-full border-[#C5C6CF] bg-white text-[#00081E] font-body text-[17px] focus:border-[#B71032] focus:ring-0 rounded-none">
                            <option value="All Centers">All Centers</option>
                            <option value="Institute for Sustainable Energy">Institute for Sustainable Energy</option>
                            <option value="Center for Digital Ethics">Center for Digital Ethics</option>
                            <option value="Genomics Research Institute">Genomics Research Institute</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-[#00081E] text-white font-sans font-semibold text-sm py-3 hover:bg-gray-800 transition-colors uppercase tracking-wider mt-2">
                        Apply Filters
                    </button>
                </form>
            </div>

            <!-- Trending Research -->
            <div>
                <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-6 border-b-2 border-[#B71032] pb-2 inline-block">Trending Research</h3>
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
                                ['category' => 'DATA SCIENCE', 'title' => 'Predictive Models for Global Supply Chain Disruptions', 'date' => 'Nov 12, 2024', 'url' => route('home')],
                                ['category' => 'MEDICINE', 'title' => 'New Pathways in Targeted Immunotherapy Discovered', 'date' => 'Nov 12, 2024', 'url' => route('home')],
                                ['category' => 'ECONOMICS', 'title' => 'Analyzing the Long-term Impacts of Universal Basic Income Trials', 'date' => 'Nov 12, 2024', 'url' => route('home')],
                                ['category' => 'MATERIALS SCIENCE', 'title' => 'Ultra-lightweight Polymers Developed for Aerospace Applications', 'date' => 'Nov 12, 2024', 'url' => route('home')],
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


            <!-- Ad Slot -->
            <div class="bg-gray-100 border border-[#C5C6CF] p-4 text-center">
                <div class="font-sans text-xs text-[#44464E] uppercase tracking-widest mb-2">Sponsor Content</div>
                <div class="bg-white h-[250px] flex flex-col items-center justify-center p-6 border border-[#C5C6CF] relative overflow-hidden group cursor-pointer">
                    <img alt="Sponsor Background" class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-30 transition-opacity" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBsX23uj298HxCx0tuCNsC_ePp73fojULmHJd-9Otlg59CbCEHEC-lXDMf3ACrpyeZRsIF1mwRzmlP9Mjgv6E0gRTGlYeVVYGV7CeKe0UULHnZcAo-TCFxVcman8zZqBA_QwYFbFQ03n86jH92pfpfonGv6Qm6XgbhB7ld4C_WezmNuydAY2O3Avrdd8JeE-pzMxO5uWA7-q29QaDSYhjObWPy2SeThbWwhb_YrVZ4I8mOVWPyQgDsS"/>
                    <div class="relative z-10 text-center">
                        <svg class="w-10 h-10 text-[#00081E] mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <h4 class="font-heading font-semibold text-2xl text-[#00081E] mb-2">TechCorp Innovates</h4>
                        <p class="font-sans text-xs text-[#44464E]">Partnering with leading minds to build tomorrow's infrastructure.</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('researchSystem', () => ({
        form: {
            field: 'All Fields',
            center: 'All Centers'
        },
        activeFilter: {
            field: 'All Fields',
            center: 'All Centers'
        },
        @php
            $researchFields = ['Biomedical Sciences', 'Engineering & Applied Science', 'Social Sciences & Humanities', 'Computer Science & AI'];
            $researchCenters = ['Institute for Sustainable Energy', 'Center for Digital Ethics', 'Genomics Research Institute', 'All Centers'];
        @endphp
        allResearch: [
            @foreach($articles as $article)
            {
                id: 'db_{{ $article->id }}',
                title: @json($article->title),
                category: @json($article->tags->first() ? $article->tags->first()->name : $article->category->name),
                date: @json($article->published_at->format('M d')),
                excerpt: @json($article->excerpt),
                image: @json($article->featured_image_path ? (Str::startsWith($article->featured_image_path, ['http://', 'https://']) ? $article->featured_image_path : asset('storage/' . $article->featured_image_path)) : 'https://picsum.photos/seed/fallback/800/533'),
                url: @json(route('article', $article->slug)),
                field: @json($article->research_field ?: $researchFields[crc32($article->title) % 4]),
                center: @json($article->research_center ?: $researchCenters[crc32($article->title) % 4])
            },
            @endforeach

        ],

        get filteredResearch() {
            return this.allResearch.filter(item => {
                const fieldMatch = this.activeFilter.field === 'All Fields' || item.field === this.activeFilter.field;
                const centerMatch = this.activeFilter.center === 'All Centers' || item.center === this.activeFilter.center;
                return fieldMatch && centerMatch;
            });
        },

        applyFilters() {
            this.activeFilter.field = this.form.field;
            this.activeFilter.center = this.form.center;
        },

        resetFilters() {
            this.form.field = 'All Fields';
            this.form.center = 'All Centers';
            this.applyFilters();
        }
    }));
});
</script>
@endsection
