@extends('layouts.public')

@section('title', 'Events - University News')

@section('content')
<main class="bg-[#FCF8F9] min-h-screen pb-20">
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-12">
        
        <!-- Page Header -->
        <div class="border-b border-[#C5C6CF] pb-4 mb-8">
            <h1 class="font-heading font-semibold text-3xl text-[#00081E]">EVENTS</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-12">
            
            <!-- Main Content (Left) -->
            <div>
                <!-- Featured Event -->
                <div class="bg-white border border-[#C5C6CF] mb-10 overflow-hidden relative group cursor-pointer hover:shadow-lg transition-shadow">
                    <!-- Image Area -->
                    <div class="relative h-[400px] w-full">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop" alt="Concert" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        
                        <!-- FEATURED Badge -->
                        <div class="absolute top-6 left-6 bg-crimson text-white text-xs font-bold px-3 py-1 uppercase tracking-wider">
                            FEATURED
                        </div>

                        <!-- Date Badge -->
                        <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-md">
                            <div class="bg-crimson text-white text-[32px] font-bold pt-4 pb-1 px-5 leading-none font-sans">15</div>
                            <div class="bg-crimson text-white text-[12px] font-bold pb-4 px-5 tracking-widest uppercase">NOV</div>
                        </div>

                        <!-- Text Content over image -->
                        <div class="absolute bottom-8 left-8 right-8 text-white">
                            <div class="text-crimson font-sans font-bold text-sm uppercase tracking-wider mb-3">SENI & BUDAYA</div>
                            <h2 class="font-heading font-bold text-[40px] mb-4 leading-[1.1] text-white drop-shadow-md">
                                Konser Orkestra Simfoni Universitas Musim Gugur
                            </h2>
                            <p class="text-white/90 text-base max-w-2xl drop-shadow">
                                Pertunjukan istimewa menampilkan karya-karya klasik dan kontemporer oleh mahasiswa fakultas seni pertunjukan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Events List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    
                    <!-- Event Item 1 -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                        <!-- Thumbnail Image (Top) -->
                        <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1517502884422-41eaead166d4?q=80&w=600&auto=format&fit=crop" alt="Exhibition" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <!-- Date Badge on Thumbnail -->
                            <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-sm">
                                <div class="bg-crimson text-white text-2xl font-bold pt-3 pb-1 px-4 leading-none font-sans">18</div>
                                <div class="bg-crimson text-white text-[10px] font-bold pb-3 px-4 tracking-widest uppercase">NOV</div>
                            </div>
                        </div>
                        <!-- Content Block (Bottom) -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-crimson font-sans font-bold text-[11px] uppercase tracking-wider mb-3">PAMERAN</div>
                                <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-crimson transition-colors cursor-pointer leading-snug">
                                    Pameran Karya Akhir Mahasiswa Arsitektur 2024
                                </h3>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="inline-block text-crimson hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider">
                                    DAFTAR
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Item 2 -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=600&auto=format&fit=crop" alt="Sports" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-sm">
                                <div class="bg-crimson text-white text-2xl font-bold pt-3 pb-1 px-4 leading-none font-sans">20</div>
                                <div class="bg-crimson text-white text-[10px] font-bold pb-3 px-4 tracking-widest uppercase">NOV</div>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-crimson font-sans font-bold text-[11px] uppercase tracking-wider mb-3">OLAHRAGA</div>
                                <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-crimson transition-colors cursor-pointer leading-snug">
                                    Final Kejuaraan Bola Basket Antar Fakultas
                                </h3>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="inline-block text-crimson hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider">
                                    DAFTAR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ loading: false, loaded: false }" class="relative mb-12">
                    <!-- Main Grid (Unified) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 overflow-hidden transition-all duration-1000 ease-in-out"
                         :class="loaded ? 'max-h-[5000px]' : 'max-h-[350px]'">
                        
                        <!-- Event Item 3 (Dummy) -->
                        <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                            <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600&auto=format&fit=crop" alt="Workshop" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-sm">
                                    <div class="bg-crimson text-white text-2xl font-bold pt-3 pb-1 px-4 leading-none font-sans">15</div>
                                    <div class="bg-crimson text-white text-[10px] font-bold pb-3 px-4 tracking-widest uppercase">NOV</div>
                                </div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-crimson font-sans font-bold text-[11px] uppercase tracking-wider mb-3">WORKSHOP</div>
                                    <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-crimson transition-colors cursor-pointer leading-snug">
                                        Workshop Penulisan Karya Tulis Ilmiah untuk Mahasiswa Baru
                                    </h3>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="inline-block text-crimson hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider">
                                        DAFTAR
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Event Item 4 (Dummy) -->
                        <div class="bg-white border border-[#C5C6CF] flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                            <div class="relative w-full h-[240px] flex-shrink-0 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1523580494112-071d4581a59c?q=80&w=600&auto=format&fit=crop" alt="Seminar" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute top-0 right-0 bg-crimson text-center overflow-hidden shadow-sm">
                                    <div class="bg-crimson text-white text-2xl font-bold pt-3 pb-1 px-4 leading-none font-sans">22</div>
                                    <div class="bg-crimson text-white text-[10px] font-bold pb-3 px-4 tracking-widest uppercase">NOV</div>
                                </div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-crimson font-sans font-bold text-[11px] uppercase tracking-wider mb-3">SEMINAR</div>
                                    <h3 class="font-heading font-semibold text-[18px] text-[#00081E] mb-4 hover:text-crimson transition-colors cursor-pointer leading-snug">
                                        Seminar Nasional: Menghadapi Era Society 5.0
                                    </h3>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="inline-block text-crimson hover:text-[#00081E] transition-colors text-xs font-bold uppercase tracking-wider">
                                        DAFTAR
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
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">1</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">2</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">3</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">4</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">5</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">6</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">7</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">8</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">9</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">10</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">11</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">12</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">13</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">14</div>
                        <!-- Featured day 15 (filled) -->
                        <div class="py-1 bg-crimson text-white rounded font-bold cursor-pointer shadow-sm">15</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">16</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">17</div>
                        <!-- Event day 18 (outlined) -->
                        <div class="py-1 border border-crimson text-crimson rounded font-bold cursor-pointer">18</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">19</div>
                        <!-- Event day 20 (outlined) -->
                        <div class="py-1 border border-crimson text-crimson rounded font-bold cursor-pointer">20</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">21</div>
                        <!-- Event day 22 (outlined) -->
                        <div class="py-1 border border-crimson text-crimson rounded font-bold cursor-pointer">22</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">23</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">24</div>
                        <!-- Event day 25 (outlined) -->
                        <div class="py-1 border border-crimson text-crimson rounded font-bold cursor-pointer">25</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">26</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">27</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">28</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">29</div>
                        <div class="py-1 hover:bg-[#EAE7E8] cursor-pointer rounded">30</div>
                        <!-- Next month -->
                        <div class="py-1 text-gray-300">1</div>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="bg-[#F0EDEE] p-6 rounded-lg">
                    <h4 class="font-heading font-bold text-[22px] text-[#00081E] mb-6 border-b border-[#C5C6CF] pb-2">Filter Kategori</h4>
                    <ul class="space-y-4">
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-crimson transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v6m-3-2.5h6"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Akademik</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-crimson transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Olahraga</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-crimson transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Seni & Budaya</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-crimson transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Kemahasiswaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 text-[#44464E] hover:text-crimson transition-colors">
                                <svg class="w-5 h-5 text-[#7687B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-sans font-medium text-[15px]">Seminar Umum</span>
                            </a>
                        </li>
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
@endsection
