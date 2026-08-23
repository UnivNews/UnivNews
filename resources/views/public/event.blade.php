@extends('layouts.public')

@section('title', 'Events - University News')

@section('content')
<main class="bg-[#FCF8F9] min-h-screen pb-20" x-data="eventSystem()">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12">
        
        <!-- Page Header -->
        <div class="border-b border-[#C5C6CF] pb-4 mb-8">
            <h1 class="font-heading font-semibold text-3xl text-[#00081E]">EVENTS</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-12">
            
            <!-- Main Content (Left) -->
            <div>
                <!-- Featured Event Slider -->
                <div class="bg-white border border-[#C5C6CF] mb-10 overflow-hidden relative" 
                     x-data="{
                        currentSlide: 0,
                        slides: [
                            { day: '15', month: 'NOV', tag: 'SENI & BUDAYA', title: 'Konser Orkestra Simfoni Universitas Musim Gugur', desc: 'Pertunjukan istimewa menampilkan karya-karya klasik dan kontemporer oleh mahasiswa fakultas seni pertunjukan.', image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop' },
                            { day: '22', month: 'NOV', tag: 'SEMINAR', title: 'Seminar Nasional: Menghadapi Era Society 5.0', desc: 'Diskusi panel bersama pakar teknologi dan akademisi terkemuka membahas tantangan dan peluang di era Society 5.0.', image: 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop' },
                            { day: '28', month: 'NOV', tag: 'OLAHRAGA', title: 'Turnamen Futsal Rektor Cup 2024', desc: 'Kompetisi futsal terbesar antar fakultas memperebutkan piala bergulir dan hadiah jutaan rupiah.', image: 'https://picsum.photos/seed/event8/2070/1200' }
                        ],
                        autoplay: null,
                        startAutoplay() { this.autoplay = setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.slides.length; }, 5000); },
                        stopAutoplay() { clearInterval(this.autoplay); },
                        goToSlide(i) { this.currentSlide = i; this.stopAutoplay(); this.startAutoplay(); }
                     }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                    <!-- Image Area -->
                    <div class="relative h-[400px] w-full">
                        <template x-for="(slide, idx) in slides" :key="idx">
                            <div class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                                 :class="currentSlide === idx ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                <img :src="slide.image" :alt="slide.tag" class="w-full h-full object-cover transition-transform duration-[6000ms] ease-linear" :class="currentSlide === idx ? 'scale-105' : 'scale-100'">
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                
                                <!-- FEATURED Badge -->
                                <div class="absolute top-6 left-6 bg-crimson text-white text-xs font-bold px-3 py-1 uppercase tracking-wider">
                                    FEATURED
                                </div>

                                <!-- Date Badge -->
                                <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-md">
                                    <div class="bg-crimson text-white text-[32px] font-bold pt-4 pb-1 px-5 leading-none font-sans" x-text="slide.day"></div>
                                    <div class="bg-crimson text-white text-[12px] font-bold pb-4 px-5 tracking-widest uppercase" x-text="slide.month"></div>
                                </div>

                                <!-- Text Content over image -->
                                <div class="absolute bottom-8 left-8 right-8 text-white">
                                    <div class="text-crimson font-sans font-bold text-sm uppercase tracking-wider mb-3" x-text="slide.tag"></div>
                                    <h2 class="font-heading font-bold text-[40px] mb-4 leading-[1.1] text-white drop-shadow-md" x-text="slide.title"></h2>
                                    <p class="text-white/90 text-base max-w-2xl drop-shadow" x-text="slide.desc"></p>
                                </div>
                            </div>
                        </template>

                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-8 z-20 flex items-center space-x-2">
                            <template x-for="(slide, idx) in slides" :key="'dot-'+idx">
                                <button @click="goToSlide(idx)" 
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                        :class="currentSlide === idx ? 'bg-crimson w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mb-12 min-h-[400px]">
                    <!-- Empty State -->
                    <div x-show="filteredEvents.length === 0" class="flex flex-col items-center justify-center h-64 text-center border border-[#C5C6CF] border-dashed rounded-lg bg-gray-50" x-cloak>
                        <svg class="w-12 h-12 text-[#C5C6CF] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-[#44464E] font-medium font-sans">Tidak ada event yang sesuai dengan filter.</p>
                        <button @click="resetFilters()" class="mt-4 text-crimson text-sm font-bold uppercase tracking-wider hover:underline">Reset Filter</button>
                    </div>

                    <!-- Events Grid -->
                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6" x-show="filteredEvents.length > 0">
                        <template x-for="event in filteredEvents" :key="event.id">
                            <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer break-inside-avoid mb-6">
                                <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                    <img :src="event.image" :alt="event.tag" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    <!-- Date Badge on Thumbnail -->
                                    <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-sm">
                                        <div class="bg-crimson text-white text-2xl font-bold pt-3 pb-1 px-4 leading-none font-sans" x-text="event.day"></div>
                                        <div class="bg-crimson text-white text-[10px] font-bold pb-3 px-4 tracking-widest uppercase" x-text="event.month"></div>
                                    </div>
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="text-crimson font-sans font-bold text-[11px] uppercase tracking-wider mb-3" x-text="event.tag"></div>
                                        <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-crimson transition-colors cursor-pointer leading-snug" x-text="event.title"></h3>
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="inline-block text-crimson hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider">
                                            DAFTAR
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Sidebar (Right) -->
            <aside class="space-y-8">
                
                <!-- Calendar Widget -->
                <div class="bg-[#F0EDEE] p-6 rounded-lg">
                    <div class="mb-6">
                        <h4 class="font-heading font-bold text-[22px] text-[#00081E]">November 2024</h4>
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
                                     'bg-crimson text-white shadow-sm font-bold': selectedDate === day,
                                     'border border-crimson text-crimson font-bold': hasEventOnDay(day) && selectedDate !== day,
                                     'hover:bg-[#EAE7E8] text-[#44464E]': !hasEventOnDay(day) && selectedDate !== day
                                 }"
                                 x-text="day">
                            </div>
                        </template>

                        <!-- Next month -->
                        <div class="py-1 text-gray-300">1</div>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="bg-[#F0EDEE] p-6 rounded-lg">
                    <h4 class="font-heading font-bold text-[22px] text-[#00081E] mb-6 border-b border-[#C5C6CF] pb-2">Filter Kategori</h4>
                    <ul class="space-y-4">
                        <template x-for="category in categories" :key="category.name">
                            <li>
                                <a href="#" @click.prevent="toggleCategory(category.name)" 
                                   class="flex items-center space-x-3 transition-colors"
                                   :class="selectedCategory === category.name ? 'text-crimson font-bold' : 'text-[#44464E] hover:text-crimson'">
                                    <span x-html="category.icon" :class="selectedCategory === category.name ? 'text-crimson' : 'text-[#7687B2]'" class="w-5 h-5 flex items-center justify-center"></span>
                                    <span class="font-sans font-medium text-[15px]" x-text="category.name"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Acara Utama Pekan Ini -->
                <div class="bg-[#F0EDEE] p-6 rounded-lg">
                    <div class="mb-6 border-b border-[#C5C6CF] pb-2">
                        <h4 class="font-heading font-bold text-[22px] text-[#00081E]">Acara Utama Pekan Ini</h4>
                    </div>
                    
                    <ul class="space-y-5">
                        <li class="flex items-start">
                            <div class="bg-transparent text-center min-w-[36px] mr-4 pt-1">
                                <div class="text-[10px] font-bold text-crimson uppercase tracking-widest leading-none mb-1">NOV</div>
                                <div class="text-[20px] font-heading font-bold text-crimson leading-none">15</div>
                            </div>
                            <div>
                                <a href="#" class="font-heading font-bold text-[15px] text-[#00081E] hover:text-crimson transition-colors leading-snug block">Konser Orkestra Simfoni Universitas Musim Gugur</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-transparent text-center min-w-[36px] mr-4 pt-1">
                                <div class="text-[10px] font-bold text-[#4C5E86] uppercase tracking-widest leading-none mb-1">NOV</div>
                                <div class="text-[20px] font-heading font-bold text-[#4C5E86] leading-none">18</div>
                            </div>
                            <div>
                                <a href="#" class="font-heading font-bold text-[15px] text-[#00081E] hover:text-crimson transition-colors leading-snug block">Pameran Karya Akhir Mahasiswa Arsitektur 2024</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-transparent text-center min-w-[36px] mr-4 pt-1">
                                <div class="text-[10px] font-bold text-[#4C5E86] uppercase tracking-widest leading-none mb-1">NOV</div>
                                <div class="text-[20px] font-heading font-bold text-[#4C5E86] leading-none">20</div>
                            </div>
                            <div>
                                <a href="#" class="font-heading font-bold text-[15px] text-[#00081E] hover:text-crimson transition-colors leading-snug block">Final Kejuaraan Bola Basket Antar Fakultas</a>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Advertisement -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="w-2 h-2 rounded-full bg-crimson mr-2"></span>
                        <h4 class="font-sans font-bold text-[10px] text-[#C5C6CF] uppercase tracking-widest">ADVERTISEMENT</h4>
                    </div>
                    <div class="bg-[#EAE7E8] rounded-lg h-[240px] flex flex-col items-center justify-center text-[#C5C6CF] border border-[#C5C6CF] border-dashed">
                        <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-sans font-bold text-xs tracking-wider uppercase opacity-70">SPONSOR CONTENT</span>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</main>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('eventSystem', () => ({
        selectedCategory: null,
        selectedDate: null,
        
        categories: [
            { name: 'Akademik', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v6m-3-2.5h6"></path></svg>' },
            { name: 'Olahraga', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>' },
            { name: 'Seni & Budaya', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>' },
            { name: 'Kemahasiswaan', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>' },
            { name: 'Seminar Umum', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' }
        ],

        allEvents: [
            { 
                id: 1, 
                category: 'Seni & Budaya', 
                day: 18, 
                month: 'NOV', 
                tag: 'PAMERAN',
                title: 'Pameran Karya Akhir Mahasiswa Arsitektur 2024', 
                image: 'https://images.unsplash.com/photo-1517502884422-41eaead166d4?q=80&w=600&auto=format&fit=crop' 
            },
            { 
                id: 2, 
                category: 'Olahraga', 
                day: 20, 
                month: 'NOV', 
                tag: 'OLAHRAGA',
                title: 'Final Kejuaraan Bola Basket Antar Fakultas', 
                image: 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=600&auto=format&fit=crop' 
            },
            { 
                id: 3, 
                category: 'Seminar Umum', 
                day: 22, 
                month: 'NOV', 
                tag: 'SEMINAR',
                title: 'Seminar Nasional: Menghadapi Era Society 5.0', 
                image: 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600&auto=format&fit=crop' 
            },
            { 
                id: 4, 
                category: 'Kemahasiswaan', 
                day: 25, 
                month: 'NOV', 
                tag: 'DISKUSI',
                title: 'Forum Diskusi Terbuka BEM Seluruh Indonesia', 
                image: 'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?q=80&w=600&auto=format&fit=crop' 
            },
            { 
                id: 5, 
                category: 'Seni & Budaya', 
                day: 15, 
                month: 'NOV', 
                tag: 'KONSER',
                title: 'Konser Orkestra Simfoni Universitas Musim Gugur', 
                image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600&auto=format&fit=crop' 
            },
            { 
                id: 6, 
                category: 'Akademik', 
                day: 12, 
                month: 'NOV', 
                tag: 'WORKSHOP',
                title: 'Workshop Penulisan Karya Ilmiah Terindeks Scopus', 
                image: 'https://picsum.photos/seed/event6/600/400' 
            },
            { 
                id: 7, 
                category: 'Kemahasiswaan', 
                day: 5, 
                month: 'NOV', 
                tag: 'SOSIAL',
                title: 'Bakti Sosial Mahasiswa di Desa Binaan', 
                image: 'https://picsum.photos/seed/event7/600/400' 
            },
            { 
                id: 8, 
                category: 'Olahraga', 
                day: 28, 
                month: 'NOV', 
                tag: 'TURNAMEN',
                title: 'Turnamen Futsal Rektor Cup 2024', 
                image: 'https://picsum.photos/seed/event8/600/400' 
            },
            { 
                id: 9, 
                category: 'Seni & Budaya', 
                day: 9, 
                month: 'NOV', 
                tag: 'FESTIVAL',
                title: 'Festival Teater Mahasiswa Nasional Ke-15', 
                image: 'https://picsum.photos/seed/event9/600/400' 
            },
            { 
                id: 10, 
                category: 'Seminar Umum', 
                day: 14, 
                month: 'NOV', 
                tag: 'KULIAH UMUM',
                title: 'Kuliah Umum: Transformasi Digital di Sektor Publik', 
                image: 'https://picsum.photos/seed/event10/600/400' 
            },
            { 
                id: 11, 
                category: 'Akademik', 
                day: 21, 
                month: 'NOV', 
                tag: 'KOMPETISI',
                title: 'Olimpiade Sains Nasional Tingkat Universitas', 
                image: 'https://picsum.photos/seed/event11/600/400' 
            },
            { 
                id: 12, 
                category: 'Kemahasiswaan', 
                day: 8, 
                month: 'NOV', 
                tag: 'PELATIHAN',
                title: 'Pelatihan Kepemimpinan Tingkat Dasar (LKTD)', 
                image: 'https://picsum.photos/seed/event12/600/400' 
            },
            { 
                id: 13, 
                category: 'Olahraga', 
                day: 11, 
                month: 'NOV', 
                tag: 'KOMPETISI',
                title: 'Lomba Lari Kampus 10K Sempena Dies Natalis', 
                image: 'https://picsum.photos/seed/event13/600/400' 
            },
            { 
                id: 14, 
                category: 'Seminar Umum', 
                day: 26, 
                month: 'NOV', 
                tag: 'CAREER FAIR',
                title: 'Bursa Kerja Terpadu & Walk-in Interview 2024', 
                image: 'https://picsum.photos/seed/event14/600/400' 
            },
            { 
                id: 15, 
                category: 'Seni & Budaya', 
                day: 29, 
                month: 'NOV', 
                tag: 'PAMERAN',
                title: 'Pameran Fotografi: Sudut Pandang Kehidupan Kampus', 
                image: 'https://picsum.photos/seed/event15/600/400' 
            }
        ],

        get filteredEvents() {
            return this.allEvents.filter(event => {
                let matchesCategory = this.selectedCategory ? event.category === this.selectedCategory : true;
                let matchesDate = this.selectedDate ? event.day === this.selectedDate : true;
                return matchesCategory && matchesDate;
            });
        },

        toggleCategory(category) {
            this.selectedCategory = this.selectedCategory === category ? null : category;
        },

        toggleDate(day) {
            this.selectedDate = this.selectedDate === day ? null : day;
        },

        hasEventOnDay(day) {
            return this.allEvents.some(event => event.day === day);
        },

        resetFilters() {
            this.selectedCategory = null;
            this.selectedDate = null;
        }
    }));
});
</script>
@endsection
