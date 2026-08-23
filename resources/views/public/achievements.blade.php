@extends('layouts.public')

@section('title', 'Achievements - University News')

@section('content')
<main class="bg-[#FCF8F9] min-h-screen pb-20" x-data="achievementSystem()">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12">
        
        <!-- Page Header -->
        <div class="border-b border-[#C5C6CF] pb-4 mb-8">
            <h1 class="font-heading font-semibold text-3xl text-[#00081E]">ACHIEVEMENTS</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-12">
            
            <!-- Main Content (Left) -->
            <div>
                <!-- Featured Achievement Slider -->
                <div class="bg-white border border-[#C5C6CF] mb-10 overflow-hidden relative"
                     x-data="{
                        currentSlide: 0,
                        slides: [
                            { tag: 'MAJOR BREAKTHROUGH', title: 'Student Robotics Team Wins International Gold at Global Tech Symposium', desc: 'The university\'s undergraduate robotics team surpassed 40 international institutions to claim first place with their autonomous environmental monitoring drone.', image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop' },
                            { tag: 'ACADEMIC EXCELLENCE', title: 'Tim Debat Bahasa Inggris Raih Juara 1 Kompetisi Asia Tenggara', desc: 'Empat mahasiswa meraih kemenangan gemilang setelah mengalahkan 28 universitas dari 10 negara ASEAN.', image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070&auto=format&fit=crop' },
                            { tag: 'INNOVATION AWARD', title: 'Mahasiswa Fakultas Teknik Patenkan Teknologi Pengolahan Limbah Baru', desc: 'Inovasi mahasiswa dalam mengubah limbah plastik menjadi bahan bakar alternatif mendapat pengakuan internasional dan hak paten.', image: 'https://picsum.photos/seed/achieve3/2070/1200' }
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
                                <div class="absolute top-6 left-6 bg-[#B71032] text-white text-xs font-bold px-3 py-1 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                    FEATURED
                                </div>

                                <!-- Text Content over image -->
                                <div class="absolute bottom-8 left-8 right-8 text-white">
                                    <div class="text-[#B71032] font-sans font-bold text-sm uppercase tracking-wider mb-3" style="font-family: 'Work Sans', sans-serif;" x-text="slide.tag"></div>
                                    <h2 class="font-heading font-bold text-[40px] mb-4 leading-[1.1] text-white drop-shadow-md" style="font-family: Montserrat, sans-serif;" x-text="slide.title"></h2>
                                    <p class="text-white/90 text-base max-w-2xl drop-shadow" style="font-family: 'Source Serif 4', serif;" x-text="slide.desc"></p>
                                </div>
                            </div>
                        </template>

                        <!-- Slide Indicators -->
                        <div class="absolute bottom-4 left-8 z-20 flex items-center space-x-2">
                            <template x-for="(slide, idx) in slides" :key="'dot-'+idx">
                                <button @click="goToSlide(idx)" 
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                        :class="currentSlide === idx ? 'bg-[#B71032] w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mb-12 min-h-[300px]">
                    <!-- Empty State -->
                    <div x-show="filteredAchievements.length === 0" class="flex flex-col items-center justify-center h-64 text-center border border-[#C5C6CF] border-dashed rounded-lg bg-gray-50" x-cloak>
                        <svg class="w-12 h-12 text-[#C5C6CF] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-[#44464E] font-medium font-sans">Tidak ada achievements yang sesuai dengan filter.</p>
                        <button @click="selectedCategory = null" class="mt-4 text-crimson text-sm font-bold uppercase tracking-wider hover:underline">Reset Filter</button>
                    </div>

                    <!-- Achievement Cards Grid -->
                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6" x-show="filteredAchievements.length > 0">

                        <template x-for="achievement in filteredAchievements" :key="achievement.id">
                            <a href="#" class="block group bg-white border border-[#C5C6CF] hover:shadow-md transition-shadow break-inside-avoid mb-6 relative">
                                <div class="w-full bg-gray-100 border-b border-[#C5C6CF] overflow-hidden">
                                    <img :src="achievement.image" class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" :alt="achievement.title">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-widest text-crimson" style="font-family: 'Work Sans', sans-serif;" x-text="achievement.category"></span>
                                        <span class="text-xs text-gray-500 font-medium" style="font-family: 'Work Sans', sans-serif;" x-text="achievement.date"></span>
                                    </div>
                                    <h3 class="text-[18px] font-bold mb-3 group-hover:text-crimson transition-colors text-navy" style="font-family: Montserrat, sans-serif; line-height: 1.3;" x-text="achievement.title"></h3>
                                    <p class="text-[14px] text-gray-600 line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;" x-text="achievement.excerpt"></p>
                                </div>
                            </a>
                        </template>

                    </div>
                </div>

            </div>

            <!-- Sidebar (Right) -->
            <aside class="space-y-8">
                
                <!-- Achievement Highlights (Stats) -->
                <div class="bg-[#00081E] text-white p-8 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 opacity-10 transform rotate-12 group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h3 class="font-heading font-semibold text-2xl mb-6 relative z-10 border-b border-white/20 pb-2" style="font-family: Montserrat, sans-serif;">Achievement Highlights</h3>
                    <ul class="space-y-4 relative z-10">
                        <li class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <div class="font-heading font-bold text-2xl" style="font-family: Montserrat, sans-serif;">85+</div>
                                <div class="font-sans text-xs text-gray-300 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">Awards This Year</div>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <div class="font-heading font-bold text-2xl" style="font-family: Montserrat, sans-serif;">32</div>
                                <div class="font-sans text-xs text-gray-300 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">International Recognitions</div>
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <div>
                                <div class="font-heading font-bold text-2xl" style="font-family: Montserrat, sans-serif;">15</div>
                                <div class="font-sans text-xs text-gray-300 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">Faculty Grants Awarded</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Filter Kategori -->
                <div class="bg-[#F0EDEE] p-6 rounded-lg">
                    <h4 class="font-heading font-bold text-[22px] text-[#00081E] mb-6 border-b border-[#C5C6CF] pb-2" style="font-family: Montserrat, sans-serif;">Filter Category</h4>
                    <ul class="space-y-4">
                        <template x-for="category in categories" :key="category.name">
                            <li>
                                <a href="#" @click.prevent="toggleCategory(category.name)" 
                                   class="flex items-center space-x-3 transition-colors"
                                   :class="selectedCategory === category.name ? 'text-[#B71032] font-bold' : 'text-[#44464E] hover:text-[#B71032]'">
                                    <span x-html="category.icon" :class="selectedCategory === category.name ? 'text-[#B71032]' : 'text-[#7687B2]'" class="w-5 h-5 flex items-center justify-center"></span>
                                    <span class="font-sans font-medium text-[15px]" x-text="category.name"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Notable Alumni Quote -->
                <div class="bg-[#F0EDEE] rounded-lg p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest mb-5 flex items-center text-[#00081E]" style="font-family: Montserrat, sans-serif;">
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

                <!-- Advertisement -->
                <div>
                    <div class="flex items-center mb-3">
                        <span class="w-2 h-2 rounded-full bg-[#B71032] mr-2"></span>
                        <h4 class="font-sans font-bold text-[10px] text-[#C5C6CF] uppercase tracking-widest" style="font-family: 'Work Sans', sans-serif;">ADVERTISEMENT</h4>
                    </div>
                    <div class="bg-[#EAE7E8] rounded-lg h-[240px] flex flex-col items-center justify-center text-[#C5C6CF] border border-[#C5C6CF] border-dashed">
                        <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-sans font-bold text-xs tracking-wider uppercase opacity-70" style="font-family: 'Work Sans', sans-serif;">SPONSOR CONTENT</span>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</main>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('achievementSystem', () => ({
        selectedCategory: null,
        
        categories: [
            { name: 'Students', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>' },
            { name: 'Faculty', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>' },
            { name: 'Science', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>' },
            { name: 'Arts & Humanities', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>' },
            { name: 'Athletics', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>' }
        ],

        allAchievements: [
            { id: 1, category: 'Science', date: 'Nov 15', title: 'Robotics Lab Unveils Autonomous Campus Delivery Prototype', excerpt: 'A team of graduate students has developed a self-navigating rover designed to deliver library books and small packages safely across pedestrian walkways.', image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=600&auto=format&fit=crop' },
            { id: 2, category: 'Students', date: 'Nov 12', title: 'Business School Launches New Venture Capital Fellowship', excerpt: 'The fellowship will provide 20 outstanding MBA candidates with hands-on experience managing a $5 million student-run investment fund.', image: 'https://images.unsplash.com/photo-1542744094-24638eff58bb?q=80&w=600&auto=format&fit=crop' },
            { id: 3, category: 'Science', date: 'Nov 10', title: 'New Study Links Urban Green Spaces to Lower Stress Levels in Students', excerpt: 'Researchers found a significant correlation between time spent in campus parks and reduced cortisol levels during finals week.', image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop' },
            { id: 4, category: 'Arts & Humanities', date: 'Nov 08', title: 'Annual Arts Festival Draws Record-Breaking Crowd This Weekend', excerpt: 'Over 10,000 students and local residents attended the three-day event featuring live music, student films, and interactive installations.', image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=600&auto=format&fit=crop' },
            { id: 5, category: 'Science', date: 'Nov 05', title: 'Researchers Discover Novel Enzyme that Breaks Down Microplastics', excerpt: 'A cross-disciplinary team from Biology and Chemistry has isolated a bacteria strain capable of digesting common packaging materials.', image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=600&auto=format&fit=crop' },
            { id: 6, category: 'Faculty', date: 'Nov 02', title: 'Medical School Partners with Regional Hospitals for Rural Care', excerpt: 'A new initiative will send final-year medical students to rural clinics to provide essential healthcare services while gaining clinical experience.', image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=600&auto=format&fit=crop' },
            { id: 7, category: 'Athletics', date: 'Oct 28', title: 'University Track Team Breaks State Relay Record', excerpt: 'The 4x100m relay team set a new state record this weekend, qualifying for the national championships.', image: 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?q=80&w=600&auto=format&fit=crop' },
            { id: 8, category: 'Students', date: 'Oct 25', title: 'Debate Team Secures National Championship Title', excerpt: 'After a grueling three-day tournament, the university debate society brought home the national trophy.', image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop' },
            { id: 9, category: 'Faculty', date: 'Oct 20', title: 'Professor Awarded Prestigious Humanities Fellowship', excerpt: 'Dr. Elena Rostova has been granted a two-year fellowship to complete her research on pre-colonial trade routes.', image: 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=600&auto=format&fit=crop' }
        ],

        get filteredAchievements() {
            if (!this.selectedCategory) return this.allAchievements;
            return this.allAchievements.filter(achievement => achievement.category === this.selectedCategory);
        },

        toggleCategory(category) {
            this.selectedCategory = this.selectedCategory === category ? null : category;
        }
    }));
});
</script>
@endsection
