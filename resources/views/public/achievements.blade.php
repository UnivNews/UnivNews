@extends('layouts.public')

@section('title', 'Achievements - University News')

@section('content')
<main class="bg-[#FCF8F9] min-h-screen pb-20">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12">
        
        <!-- Page Header -->
        <div class="border-b border-[#C5C6CF] pb-4 mb-8">
            <h1 class="font-heading font-semibold text-3xl text-[#00081E]">ACHIEVEMENTS</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-12">
            
            <!-- Main Content (Left) -->
            <div>
                <!-- Featured Achievement -->
                <div class="bg-white border border-[#C5C6CF] mb-10 overflow-hidden relative group cursor-pointer hover:shadow-lg transition-shadow">
                    <!-- Image Area -->
                    <div class="relative h-[400px] w-full">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" alt="Robotics Team" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        
                        <!-- FEATURED Badge -->
                        <div class="absolute top-6 left-6 bg-[#B71032] text-white text-xs font-bold px-3 py-1 uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                            FEATURED
                        </div>

                        <!-- Text Content over image -->
                        <div class="absolute bottom-8 left-8 right-8 text-white">
                            <div class="text-[#B71032] font-sans font-bold text-sm uppercase tracking-wider mb-3" style="font-family: 'Work Sans', sans-serif;">MAJOR BREAKTHROUGH</div>
                            <h2 class="font-heading font-bold text-[40px] mb-4 leading-[1.1] text-white drop-shadow-md" style="font-family: Montserrat, sans-serif;">
                                Student Robotics Team Wins International Gold at Global Tech Symposium
                            </h2>
                            <p class="text-white/90 text-base max-w-2xl drop-shadow" style="font-family: 'Source Serif 4', serif;">
                                The university's undergraduate robotics team surpassed 40 international institutions to claim first place with their autonomous environmental monitoring drone.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Achievement Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    
                    <!-- Card 1: Faculty Award -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop" alt="Dr. Evelyn Hayes" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#B71032]" style="font-family: 'Work Sans', sans-serif;">Faculty Award</span>
                                    <span class="text-xs text-[#44464E] font-medium" style="font-family: 'Work Sans', sans-serif;">Oct 18</span>
                                </div>
                                <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-[#B71032] transition-colors cursor-pointer leading-snug" style="font-family: Montserrat, sans-serif;">
                                    Dr. Evelyn Hayes Receives National Endowment for Humanities Grant
                                </h3>
                                <p class="text-[14px] text-[#44464E] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                    Recognizing her extensive research on post-industrial societal shifts in urban environments.
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="inline-block text-[#B71032] hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                    READ MORE
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Arts Excellence -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1465847899084-d164df4dedc6?q=80&w=600&auto=format&fit=crop" alt="Orchestra" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#B71032]" style="font-family: 'Work Sans', sans-serif;">Arts Excellence</span>
                                    <span class="text-xs text-[#44464E] font-medium" style="font-family: 'Work Sans', sans-serif;">Oct 12</span>
                                </div>
                                <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-[#B71032] transition-colors cursor-pointer leading-snug" style="font-family: Montserrat, sans-serif;">
                                    Symphony Orchestra Invited to Perform at Carnegie Hall
                                </h3>
                                <p class="text-[14px] text-[#44464E] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                    A historic milestone for the School of Music, marking their first invitation to the prestigious venue.
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="inline-block text-[#B71032] hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                    READ MORE
                                </a>
                            </div>
                        </div>
                    </div>

                <div x-data="{ loading: false, loaded: false }" class="relative mb-12">
                    <!-- Main Grid (Unified) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 overflow-hidden transition-all duration-1000 ease-in-out"
                         :class="loaded ? 'max-h-[5000px]' : 'max-h-[350px]'">
                        
                        <!-- Card 3: Athletics -->
                        <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                            <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=600&auto=format&fit=crop" alt="Athletics" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#B71032]" style="font-family: 'Work Sans', sans-serif;">Athletics</span>
                                        <span class="text-xs text-[#44464E] font-medium" style="font-family: 'Work Sans', sans-serif;">Oct 05</span>
                                    </div>
                                    <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-[#B71032] transition-colors cursor-pointer leading-snug" style="font-family: Montserrat, sans-serif;">
                                        Men's Track & Field Clinches Regional Championship Title
                                    </h3>
                                    <p class="text-[14px] text-[#44464E] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                        Setting three new university records and securing a spot in the national finals.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="inline-block text-[#B71032] hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                        READ MORE
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Institutional Milestone -->
                        <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                            <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop" alt="Sustainability" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#B71032]" style="font-family: 'Work Sans', sans-serif;">Institutional Milestone</span>
                                        <span class="text-xs text-[#44464E] font-medium" style="font-family: 'Work Sans', sans-serif;">Sept 28</span>
                                    </div>
                                    <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-[#B71032] transition-colors cursor-pointer leading-snug" style="font-family: Montserrat, sans-serif;">
                                        University Ranked Top 10 for Sustainable Campus Initiatives
                                    </h3>
                                    <p class="text-[14px] text-[#44464E] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                        Following the opening of the Green Innovation Hub, the university has been recognized globally for its commitment to zero-emission infrastructure.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="inline-block text-[#B71032] hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                        READ MORE
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 5 (Dummy) -->
                        <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                            <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=600&auto=format&fit=crop" alt="Science" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#B71032]" style="font-family: 'Work Sans', sans-serif;">Science</span>
                                        <span class="text-xs text-[#44464E] font-medium" style="font-family: 'Work Sans', sans-serif;">Sept 20</span>
                                    </div>
                                    <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-[#B71032] transition-colors cursor-pointer leading-snug" style="font-family: Montserrat, sans-serif;">
                                        Biology Department Discovers New Species of Deep Sea Coral
                                    </h3>
                                    <p class="text-[14px] text-[#44464E] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                        A multi-university expedition led by our marine biologists uncovered a thriving ecosystem previously unknown to science.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="inline-block text-[#B71032] hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                        READ MORE
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 6 (Dummy) -->
                        <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                            <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=600&auto=format&fit=crop" alt="Students" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#B71032]" style="font-family: 'Work Sans', sans-serif;">Students</span>
                                        <span class="text-xs text-[#44464E] font-medium" style="font-family: 'Work Sans', sans-serif;">Sept 15</span>
                                    </div>
                                    <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-[#B71032] transition-colors cursor-pointer leading-snug" style="font-family: Montserrat, sans-serif;">
                                        Undergraduate Startup Wins TechCrunch Disrupt Startup Battlefield
                                    </h3>
                                    <p class="text-[14px] text-[#44464E] line-clamp-3" style="font-family: 'Source Serif 4', serif; line-height: 1.6;">
                                        Three computer science seniors successfully pitched their AI-driven accessibility platform to top Silicon Valley investors.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="inline-block text-[#B71032] hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider" style="font-family: 'Work Sans', sans-serif;">
                                        READ MORE
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Fade Overlay & Load More Button -->
                    <div class="absolute bottom-0 left-0 right-0 flex flex-col items-center justify-end h-64 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none"
                         x-show="!loaded"
                         x-transition.opacity.duration.500ms>
                        
                        <div class="pb-2 pointer-events-auto border-t border-[#C5C6CF] w-full pt-10 mt-10">
                            <div class="flex justify-center">
                                <button @click="loading = true; setTimeout(() => { loading = false; loaded = true; }, 1000)"
                                        class="inline-block font-sans font-semibold text-sm text-[#00081E] border border-[#00081E] px-8 py-3 hover:bg-[#00081E] hover:text-white transition-colors uppercase tracking-wider relative min-w-[200px] bg-white"
                                        style="font-family: 'Work Sans', sans-serif;"
                                        :disabled="loading">
                                    <span x-show="!loading">Load More</span>
                                    <span x-show="loading" class="flex items-center justify-center">
                                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
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
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-[#B71032] transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Students</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-[#B71032] transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Faculty</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-[#B71032] transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Science</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-[#B71032] transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Arts & Humanities</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-[#B71032] transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Athletics</span>
                            </a>
                        </li>
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
@endsection
