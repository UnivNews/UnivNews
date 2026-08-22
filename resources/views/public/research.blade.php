@extends('layouts.public')

@section('content')
<div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12 min-h-screen">
    <div class="mb-12 border-b border-[#C5C6CF] pb-6">
        <h1 class="font-heading text-5xl font-bold text-[#00081E] mb-4 tracking-tight uppercase">Research & Innovation</h1>
        <p class="font-sans text-xl text-[#44464E] max-w-3xl">Exploring the frontiers of knowledge and technology to address global challenges and shape the future of society.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content (Left) -->
        <div class="lg:col-span-8 space-y-12">
            <!-- Featured Hero -->
            @if($featuredResearch ?? false)
            <article class="group cursor-pointer">
                <div class="relative w-full h-[400px] mb-6 overflow-hidden bg-gray-100 border border-[#C5C6CF]">
                    <img alt="Featured Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $featuredResearch->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfg3t7NFKq4NmDP4lDCYPRZx3WQ8gSFSHj-oUFb4DvBvzTMd_FYnyG5NnFljmuENjsLuQSfe_kd_uPywkloyFKa8B3qjfOAQn_ldve0GSmJ83X2xetsCkd3nBLamQEj6E4jfuOPOoS_nk8V21MAzwju3IzqBoklME8dwOr50HPaEEbhG1CGGvM7WFzH_uSd3ws1rEWHDWgTvj0qdLw9NcRh9fAS9_NISw0r0-Z9uQEF4W5CBMLHKo9' }}"/>
                    <div class="absolute top-4 left-4 bg-[#B71032] text-white px-3 py-1 font-sans font-semibold text-xs tracking-wider uppercase">
                        ACADEMIC BREAKTHROUGH
                    </div>
                </div>
                <div>
                    <h2 class="font-heading font-semibold text-[32px] leading-tight text-[#00081E] mb-4 group-hover:text-[#B71032] transition-colors">
                        {{ $featuredResearch->title }}
                    </h2>
                    <p class="font-body text-[17px] leading-[28px] text-[#44464E] mb-6 line-clamp-3">
                        {{ $featuredResearch->excerpt }}
                    </p>
                    <a href="{{ route('article', $featuredResearch->slug) }}" class="inline-block font-sans font-semibold text-sm text-[#00081E] border border-[#00081E] px-6 py-3 hover:bg-[#00081E] hover:text-white transition-colors uppercase tracking-wider">
                        Read More
                    </a>
                </div>
            </article>
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

            <!-- Research Grid with Dynamic Load More -->
            <div x-data="{ loading: false, loaded: false }" class="relative mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 overflow-hidden transition-all duration-1000 ease-in-out"
                     :class="loaded ? 'max-h-[5000px]' : 'max-h-[600px]'">
                     
                    <article class="group cursor-pointer flex flex-col h-full bg-[#FCF8F9] border border-[#C5C6CF] hover:bg-white transition-colors">
                        <div class="h-48 overflow-hidden relative">
                            <img alt="Public Health Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBC2wXpL1P6C7B1nQG4Y4hC59u4D5E1n8-wL8105H24oB9q98gM7OqyR_-0z8vB7s3e1W50mO3jHk3F7yH_3H_Y7z7r3W3QzZ80u_b1z8kH200o_n2m1Z7fN802cE-0-WzN0YxL88uK0-NfC0o_aZ7X7tQfR9jJ_nKjP6s-M5Y6R4rN5kOqN0c"/>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-[#B71032] font-sans font-semibold text-sm mb-2 uppercase tracking-wider">PUBLIC HEALTH</div>
                            <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-3 group-hover:underline decoration-[#B71032] underline-offset-4">New Strategies in Epidemic Tracking</h3>
                            <p class="font-body text-[17px] text-[#44464E] mb-4 flex-grow line-clamp-3">A multi-disciplinary team develops a real-time data modeling framework that improves prediction of viral spread patterns by up to 40%.</p>
                            <a class="font-sans font-semibold text-sm text-[#00081E] hover:text-[#B71032] flex items-center gap-2 mt-auto" href="#">
                                View Project 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>

                    <article class="group cursor-pointer flex flex-col h-full bg-[#FCF8F9] border border-[#C5C6CF] hover:bg-white transition-colors">
                        <div class="h-48 overflow-hidden relative">
                            <img alt="AI Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZpFGSPeWsP-76HL2LAjBhT3szbaJ-iy26G_1SPXBzI9F8WgI5by5YMSnLQAbUbyGccWmH0PUqyliMtTsNd3GnGJZOI-eByI-DVj5Nzj5u_bOAypw7CmXW0vB1wq_CBls-vqDUaZbpADAhqZh6G2wONILuQYbjFyR2zNe2aFVYkd2t0FtnvhN3f0rAoExpGamqQcfV0yoKCbKo1xJIrP2Pfrk4oH2_QFNjbt8M86K_g104BpQri2L2"/>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-[#B71032] font-sans font-semibold text-sm mb-2 uppercase tracking-wider">ARTIFICIAL INTELLIGENCE</div>
                            <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-3 group-hover:underline decoration-[#B71032] underline-offset-4">Ethical Frameworks for Autonomous Systems</h3>
                            <p class="font-body text-[17px] text-[#44464E] mb-4 flex-grow line-clamp-3">The Center for Digital Ethics publishes a comprehensive guide on implementing human-centric moral reasoning algorithms into autonomous vehicles.</p>
                            <a class="font-sans font-semibold text-sm text-[#00081E] hover:text-[#B71032] flex items-center gap-2 mt-auto" href="#">
                                View Project 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>

                    <article class="group cursor-pointer flex flex-col h-full bg-[#FCF8F9] border border-[#C5C6CF] hover:bg-white transition-colors">
                        <div class="h-48 overflow-hidden relative">
                            <img alt="Sustainability Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzlA8x7OQls5LI9ZZ6-2RGs8GazT3YBOkyol2naUtJLg8dQV04dPy6Zax4gDKorU1lDb7H51TReMMHDW-d826ghWpP5etvNClJ1RM4qae6MH1GFVueJBHdVeTr4t3D-L3_GdBtuoEjIqZ8QVki0XNz7yFDXmvTqJcKh9J3afcc2_hg8NJ02NnQ2qneBLB27YU3BEMSnoapqykjGUpvBJGjscKV6gxmoOvKv4dd0W9H3SCjh-2Wyjc1"/>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-[#B71032] font-sans font-semibold text-sm mb-2 uppercase tracking-wider">SUSTAINABILITY</div>
                            <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-3 group-hover:underline decoration-[#B71032] underline-offset-4">Next-Generation Urban Water Management</h3>
                            <p class="font-body text-[17px] text-[#44464E] mb-4 flex-grow line-clamp-3">Engineering faculty unveil a modular infrastructure design that reclaims and purifies urban runoff using passive, low-energy bio-filtration systems.</p>
                            <a class="font-sans font-semibold text-sm text-[#00081E] hover:text-[#B71032] flex items-center gap-2 mt-auto" href="#">
                                View Project 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>

                    <article class="group cursor-pointer flex flex-col h-full bg-[#FCF8F9] border border-[#C5C6CF] hover:bg-white transition-colors">
                        <div class="h-48 overflow-hidden relative">
                            <img alt="Physics Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDHFsIO7UV6UeuMGAQWscmeOrQ451xwQhDKJfbJKE93wKdkejq0W5Lbiuki3YrtjHPZOxVunRVJql7aVQ7jlNKdoW_Jd_NCzUgh6EA7ZDGCUAmT5U_br4F1VUxNgYrqMf_cCevfbxeJnIhq4LrB59BRzUP7L1a8Hwxb7ijh9pbPbf-uOL3Q-aHlXeJYLHhywzKzNRouWExTHSFWOElu8ybVbXW7y-Ek1sJP0rN4TWd-rr-nEnZd8tSb"/>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-[#B71032] font-sans font-semibold text-sm mb-2 uppercase tracking-wider">QUANTUM PHYSICS</div>
                            <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-3 group-hover:underline decoration-[#B71032] underline-offset-4">Achieving Room-Temperature Superconductivity</h3>
                            <p class="font-body text-[17px] text-[#44464E] mb-4 flex-grow line-clamp-3">Physics department claims a minor but significant leap in stabilizing superconducting materials at elevated temperatures using novel pressure techniques.</p>
                            <a class="font-sans font-semibold text-sm text-[#00081E] hover:text-[#B71032] flex items-center gap-2 mt-auto" href="#">
                                View Project 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>

                    <!-- Dummy Article 1 -->
                    <article class="group cursor-pointer flex flex-col h-full bg-[#FCF8F9] border border-[#C5C6CF] hover:bg-white transition-colors">
                        <div class="h-48 overflow-hidden relative">
                            <img alt="Medical Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=600&auto=format&fit=crop"/>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-[#B71032] font-sans font-semibold text-sm mb-2 uppercase tracking-wider">MEDICINE</div>
                            <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-3 group-hover:underline decoration-[#B71032] underline-offset-4">Breakthrough in Cellular Regeneration</h3>
                            <p class="font-body text-[17px] text-[#44464E] mb-4 flex-grow line-clamp-3">Researchers have identified a new protein pathway that significantly accelerates the healing of damaged neural tissues in preliminary trials.</p>
                            <a class="font-sans font-semibold text-sm text-[#00081E] hover:text-[#B71032] flex items-center gap-2 mt-auto" href="#">
                                View Project 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>

                    <!-- Dummy Article 2 -->
                    <article class="group cursor-pointer flex flex-col h-full bg-[#FCF8F9] border border-[#C5C6CF] hover:bg-white transition-colors">
                        <div class="h-48 overflow-hidden relative">
                            <img alt="AI Research" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?q=80&w=600&auto=format&fit=crop"/>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-[#B71032] font-sans font-semibold text-sm mb-2 uppercase tracking-wider">ARTIFICIAL INTELLIGENCE</div>
                            <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-3 group-hover:underline decoration-[#B71032] underline-offset-4">Ethical Frameworks in Machine Learning</h3>
                            <p class="font-body text-[17px] text-[#44464E] mb-4 flex-grow line-clamp-3">A joint study between the philosophy and computer science departments proposes a new computable framework for embedding ethical constraints into LLMs.</p>
                            <a class="font-sans font-semibold text-sm text-[#00081E] hover:text-[#B71032] flex items-center gap-2 mt-auto" href="#">
                                View Project 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Fade Overlay & Load More Button -->
                <div class="absolute bottom-0 left-0 right-0 flex flex-col items-center justify-end h-64 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none"
                     x-show="!loaded"
                     x-transition.opacity.duration.500ms>
                    
                    <div class="pb-2 pointer-events-auto border-t border-[#C5C6CF] w-full pt-10 mt-10">
                        <div class="flex justify-center">
                            <button @click="loading = true; setTimeout(() => { loading = false; loaded = true; }, 1000)"
                                    class="inline-block font-sans font-semibold text-sm text-[#00081E] border border-[#00081E] px-8 py-3 hover:bg-[#00081E] hover:text-white transition-colors uppercase tracking-wider relative min-w-[200px] bg-[#FCF8F9]"
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
        <aside class="lg:col-span-4 space-y-10">
            <!-- Filter Widget -->
            <div class="bg-[#FCF8F9] border border-[#C5C6CF] p-6">
                <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-4 border-b-2 border-[#B71032] pb-2 inline-block">Filter Research</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block font-sans font-semibold text-sm text-[#44464E] mb-2">Research Field</label>
                        <select class="w-full border-[#C5C6CF] bg-white text-[#00081E] font-body text-[17px] focus:border-[#B71032] focus:ring-0 rounded-none">
                            <option>All Fields</option>
                            <option>Biomedical Sciences</option>
                            <option>Engineering & Applied Science</option>
                            <option>Social Sciences & Humanities</option>
                            <option>Computer Science & AI</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-sans font-semibold text-sm text-[#44464E] mb-2">Research Center/Lab</label>
                        <select class="w-full border-[#C5C6CF] bg-white text-[#00081E] font-body text-[17px] focus:border-[#B71032] focus:ring-0 rounded-none">
                            <option>All Centers</option>
                            <option>Institute for Sustainable Energy</option>
                            <option>Center for Digital Ethics</option>
                            <option>Genomics Research Institute</option>
                        </select>
                    </div>
                    <button class="w-full bg-[#00081E] text-white font-sans font-semibold text-sm py-3 hover:bg-gray-800 transition-colors uppercase tracking-wider mt-2" type="button">
                        Apply Filters
                    </button>
                </form>
            </div>

            <!-- Trending Research -->
            <div>
                <h3 class="font-heading font-semibold text-2xl text-[#00081E] mb-6 border-b-2 border-[#B71032] pb-2 inline-block">Trending Research</h3>
                <div class="space-y-6">
                    <a class="group block border-l-[3px] border-transparent hover:border-[#B71032] pl-4 transition-all" href="#">
                        <div class="text-[#B71032] font-sans font-semibold text-xs uppercase tracking-wider mb-1">DATA SCIENCE</div>
                        <h4 class="font-body text-[17px] font-bold text-[#00081E] group-hover:text-[#B71032] transition-colors leading-tight">Predictive Models for Global Supply Chain Disruptions</h4>
                    </a>
                    <a class="group block border-l-[3px] border-transparent hover:border-[#B71032] pl-4 transition-all" href="#">
                        <div class="text-[#B71032] font-sans font-semibold text-xs uppercase tracking-wider mb-1">MEDICINE</div>
                        <h4 class="font-body text-[17px] font-bold text-[#00081E] group-hover:text-[#B71032] transition-colors leading-tight">New Pathways in Targeted Immunotherapy Discovered</h4>
                    </a>
                    <a class="group block border-l-[3px] border-transparent hover:border-[#B71032] pl-4 transition-all" href="#">
                        <div class="text-[#B71032] font-sans font-semibold text-xs uppercase tracking-wider mb-1">ECONOMICS</div>
                        <h4 class="font-body text-[17px] font-bold text-[#00081E] group-hover:text-[#B71032] transition-colors leading-tight">Analyzing the Long-term Impacts of Universal Basic Income Trials</h4>
                    </a>
                    <a class="group block border-l-[3px] border-transparent hover:border-[#B71032] pl-4 transition-all" href="#">
                        <div class="text-[#B71032] font-sans font-semibold text-xs uppercase tracking-wider mb-1">MATERIALS SCIENCE</div>
                        <h4 class="font-body text-[17px] font-bold text-[#00081E] group-hover:text-[#B71032] transition-colors leading-tight">Ultra-lightweight Polymers Developed for Aerospace Applications</h4>
                    </a>
                </div>
            </div>

            <!-- Innovation Metrics -->
            <div class="bg-[#00081E] text-white p-8 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 opacity-10 transform rotate-12 group-hover:scale-110 transition-transform duration-700">
                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                </div>
                <h3 class="font-heading font-semibold text-2xl mb-6 relative z-10 border-b border-white/20 pb-2">Innovation Impact</h3>
                <ul class="space-y-4 relative z-10">
                    <li class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <div class="font-heading font-bold text-2xl">150+</div>
                            <div class="font-sans text-xs text-gray-300 uppercase tracking-wider">Patents Pending</div>
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <div class="font-heading font-bold text-2xl">50+</div>
                            <div class="font-sans text-xs text-gray-300 uppercase tracking-wider">Global Partnerships</div>
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-[#B71032]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <div>
                            <div class="font-heading font-bold text-2xl">$120M</div>
                            <div class="font-sans text-xs text-gray-300 uppercase tracking-wider">Research Funding (FY23)</div>
                        </div>
                    </li>
                </ul>
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
@endsection
