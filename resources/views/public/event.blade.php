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
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop" alt="Concert" class="w-full h-full object-cover">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        
                        <!-- FEATURED Badge -->
                        <div class="absolute top-6 left-6 bg-crimson text-white text-xs font-bold px-3 py-1 uppercase tracking-wider">
                            FEATURED
                        </div>

                        <!-- Date Badge -->
                        <div class="absolute top-6 right-6 bg-crimson rounded text-center overflow-hidden shadow-md">
                            <div class="bg-white text-[#00081E] text-2xl font-bold py-2 px-4 leading-none">15</div>
                            <div class="text-white text-xs font-bold py-1 px-4 tracking-widest uppercase">NOV</div>
                        </div>

                        <!-- Text Content over image -->
                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <div class="text-crimson font-sans font-bold text-sm uppercase tracking-wider mb-2">SENI & BUDAYA</div>
                            <h2 class="font-heading font-bold text-3xl mb-3 leading-tight text-white drop-shadow-md">
                                Konser Orkestra Simfoni Universitas Musim Gugur
                            </h2>
                            <p class="font-serif text-[15px] text-gray-200 line-clamp-2 max-w-3xl">
                                Pertunjukan istimewa menampilkan karya-karya klasik dan kontemporer oleh mahasiswa fakultas seni pertunjukan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Events List -->
                <div class="flex flex-col gap-6 mb-10">
                    
                    <!-- Event Item 1 -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col md:flex-row hover:shadow-md transition-shadow">
                        <!-- Date Block (Left) -->
                        <div class="bg-crimson text-white flex flex-col items-center justify-center p-6 md:w-32 flex-shrink-0">
                            <span class="text-4xl font-bold font-heading leading-none">18</span>
                            <span class="text-sm font-bold tracking-widest mt-1">NOV</span>
                        </div>
                        <!-- Content Block (Right) -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-crimson font-sans font-bold text-xs uppercase tracking-wider mb-2">PAMERAN</div>
                                <h3 class="font-heading font-semibold text-xl text-[#00081E] mb-2 hover:text-crimson transition-colors cursor-pointer">
                                    Pameran Karya Akhir Mahasiswa Arsitektur 2024
                                </h3>
                                <p class="font-serif text-[14px] text-[#7687B2] mb-4">
                                    Menampilkan desain maket dan presentasi proyek akhir yang inovatif dari calon arsitek masa depan.
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="#" class="inline-block border border-crimson text-crimson hover:bg-crimson hover:text-white transition-colors text-xs font-bold px-6 py-2 uppercase tracking-wider">
                                    DAFTAR
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Item 2 -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col md:flex-row hover:shadow-md transition-shadow">
                        <div class="bg-[#0A1F44] text-white flex flex-col items-center justify-center p-6 md:w-32 flex-shrink-0">
                            <span class="text-4xl font-bold font-heading leading-none">20</span>
                            <span class="text-sm font-bold tracking-widest mt-1">NOV</span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-crimson font-sans font-bold text-xs uppercase tracking-wider mb-2">OLAHRAGA</div>
                                <h3 class="font-heading font-semibold text-xl text-[#00081E] mb-2 hover:text-crimson transition-colors cursor-pointer">
                                    Kompetisi Bola Voli Antar Fakultas
                                </h3>
                                <p class="font-serif text-[14px] text-[#7687B2] mb-4">
                                    Pertandingan sengit memperebutkan piala rektor tahunan. Datang dan dukung fakultasmu!
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="#" class="inline-block border border-crimson text-crimson hover:bg-crimson hover:text-white transition-colors text-xs font-bold px-6 py-2 uppercase tracking-wider">
                                    DAFTAR
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Item 3 -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col md:flex-row hover:shadow-md transition-shadow">
                        <div class="bg-[#0A1F44] text-white flex flex-col items-center justify-center p-6 md:w-32 flex-shrink-0">
                            <span class="text-4xl font-bold font-heading leading-none">22</span>
                            <span class="text-sm font-bold tracking-widest mt-1">NOV</span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-crimson font-sans font-bold text-xs uppercase tracking-wider mb-2">SEMINAR</div>
                                <h3 class="font-heading font-semibold text-xl text-[#00081E] mb-2 hover:text-crimson transition-colors cursor-pointer">
                                    Seminar Nasional: Inovasi Teknologi Hijau
                                </h3>
                                <p class="font-serif text-[14px] text-[#7687B2] mb-4">
                                    Diskusi panel bersama pakar lingkungan tentang masa depan energi terbarukan di Indonesia.
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="#" class="inline-block border border-crimson text-crimson hover:bg-crimson hover:text-white transition-colors text-xs font-bold px-6 py-2 uppercase tracking-wider">
                                    DAFTAR
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Event Item 4 -->
                    <div class="bg-white border border-[#C5C6CF] flex flex-col md:flex-row hover:shadow-md transition-shadow">
                        <div class="bg-[#0A1F44] text-white flex flex-col items-center justify-center p-6 md:w-32 flex-shrink-0">
                            <span class="text-4xl font-bold font-heading leading-none">25</span>
                            <span class="text-sm font-bold tracking-widest mt-1">NOV</span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-crimson font-sans font-bold text-xs uppercase tracking-wider mb-2">DISKUSI</div>
                                <h3 class="font-heading font-semibold text-xl text-[#00081E] mb-2 hover:text-crimson transition-colors cursor-pointer">
                                    Bedah Buku Komunikasi Politik Era Digital
                                </h3>
                                <p class="font-serif text-[14px] text-[#7687B2] mb-4">
                                    Acara bedah buku karya dosen FISIP mengupas tuntas strategi kampanye di media sosial.
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="#" class="inline-block border border-crimson text-crimson hover:bg-crimson hover:text-white transition-colors text-xs font-bold px-6 py-2 uppercase tracking-wider">
                                    DAFTAR
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-center space-x-2 border-t border-[#C5C6CF] pt-8">
                    <a href="#" class="text-[#4C5E86] hover:text-crimson font-sans font-bold text-xs tracking-wider uppercase mr-4 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        SEBELUMNYA
                    </a>
                    
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded bg-[#00081E] text-white font-sans font-bold text-sm">1</a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded hover:bg-[#F0EDEE] text-[#44464E] font-sans font-bold text-sm transition-colors">2</a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded hover:bg-[#F0EDEE] text-[#44464E] font-sans font-bold text-sm transition-colors">3</a>
                    <span class="w-10 h-10 flex items-center justify-center text-[#7687B2] font-sans font-bold text-sm">...</span>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded hover:bg-[#F0EDEE] text-[#44464E] font-sans font-bold text-sm transition-colors">12</a>
                    
                    <a href="#" class="text-[#00081E] hover:text-crimson font-sans font-bold text-xs tracking-wider uppercase ml-4 flex items-center">
                        BERIKUTNYA
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

            </div>

            <!-- Sidebar (Right) -->
            <aside class="space-y-8">
                
                <!-- Calendar Widget -->
                <div class="bg-white border border-[#C5C6CF] p-6">
                    <div class="flex justify-between items-center mb-4">
                        <button class="text-[#7687B2] hover:text-crimson"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <h4 class="font-heading font-bold text-lg text-[#00081E]">November 2024</h4>
                        <button class="text-[#7687B2] hover:text-crimson"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center mb-2">
                        <div class="text-xs font-bold text-[#7687B2] py-1">Mo</div>
                        <div class="text-xs font-bold text-[#7687B2] py-1">Tu</div>
                        <div class="text-xs font-bold text-[#7687B2] py-1">We</div>
                        <div class="text-xs font-bold text-[#7687B2] py-1">Th</div>
                        <div class="text-xs font-bold text-[#7687B2] py-1">Fr</div>
                        <div class="text-xs font-bold text-[#7687B2] py-1">Sa</div>
                        <div class="text-xs font-bold text-[#7687B2] py-1">Su</div>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center text-sm font-sans font-medium text-[#44464E]">
                        <!-- Empty slots for previous month -->
                        <div class="py-1 text-gray-300">28</div>
                        <div class="py-1 text-gray-300">29</div>
                        <div class="py-1 text-gray-300">30</div>
                        <div class="py-1 text-gray-300">31</div>
                        
                        <!-- Current month -->
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">1</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">2</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">3</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">4</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">5</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">6</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">7</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">8</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">9</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">10</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">11</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">12</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">13</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">14</div>
                        <!-- Featured day 15 -->
                        <div class="py-1 bg-crimson text-white rounded-full font-bold shadow-md cursor-pointer">15</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">16</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">17</div>
                        <!-- Event day 18 -->
                        <div class="py-1 bg-[#0A1F44] text-white rounded-full font-bold cursor-pointer">18</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">19</div>
                        <!-- Event day 20 -->
                        <div class="py-1 bg-[#0A1F44] text-white rounded-full font-bold cursor-pointer">20</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">21</div>
                        <!-- Event day 22 -->
                        <div class="py-1 bg-[#0A1F44] text-white rounded-full font-bold cursor-pointer">22</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">23</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">24</div>
                        <!-- Event day 25 -->
                        <div class="py-1 bg-[#0A1F44] text-white rounded-full font-bold cursor-pointer">25</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">26</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">27</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">28</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">29</div>
                        <div class="py-1 hover:bg-[#F0EDEE] cursor-pointer rounded-full">30</div>
                        <!-- Next month -->
                        <div class="py-1 text-gray-300">1</div>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="bg-white border border-[#C5C6CF] p-6">
                    <h4 class="font-heading font-bold text-lg text-[#00081E] mb-4 pb-2 border-b border-[#C5C6CF]">Filter Kategori</h4>
                    <ul class="space-y-3">
                        <li>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-crimson rounded-sm border-[#C5C6CF] focus:ring-crimson">
                                <span class="font-sans text-[15px] text-[#44464E] group-hover:text-crimson transition-colors">Akademik</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-crimson rounded-sm border-[#C5C6CF] focus:ring-crimson">
                                <span class="font-sans text-[15px] text-[#44464E] group-hover:text-crimson transition-colors">Olahraga</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" checked class="form-checkbox h-4 w-4 text-crimson rounded-sm border-[#C5C6CF] focus:ring-crimson">
                                <span class="font-sans text-[15px] text-[#00081E] font-medium group-hover:text-crimson transition-colors">Seni & Budaya</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-crimson rounded-sm border-[#C5C6CF] focus:ring-crimson">
                                <span class="font-sans text-[15px] text-[#44464E] group-hover:text-crimson transition-colors">Kemahasiswaan</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-crimson rounded-sm border-[#C5C6CF] focus:ring-crimson">
                                <span class="font-sans text-[15px] text-[#44464E] group-hover:text-crimson transition-colors">Seminar Umum</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <!-- Acara Utama Pekan Ini -->
                <div class="bg-[#F0EDEE] rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <span class="w-2 h-2 rounded-full bg-crimson mr-2"></span>
                        <h4 class="font-heading font-bold text-base text-[#00081E] uppercase tracking-wider">Acara Utama Pekan Ini</h4>
                    </div>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start border-b border-[#C5C6CF] pb-3 border-opacity-50">
                            <div class="bg-white border border-[#C5C6CF] rounded p-2 text-center min-w-[50px] mr-3 shadow-sm">
                                <div class="text-xs font-bold text-crimson uppercase">NOV</div>
                                <div class="text-lg font-heading font-bold text-[#00081E] leading-none">15</div>
                            </div>
                            <div>
                                <a href="#" class="font-heading font-semibold text-[15px] text-[#00081E] hover:text-crimson transition-colors line-clamp-2">Konser Orkestra Simfoni Universitas Musim Gugur</a>
                            </div>
                        </li>
                        <li class="flex items-start border-b border-[#C5C6CF] pb-3 border-opacity-50">
                            <div class="bg-white border border-[#C5C6CF] rounded p-2 text-center min-w-[50px] mr-3 shadow-sm">
                                <div class="text-xs font-bold text-crimson uppercase">NOV</div>
                                <div class="text-lg font-heading font-bold text-[#00081E] leading-none">18</div>
                            </div>
                            <div>
                                <a href="#" class="font-heading font-semibold text-[15px] text-[#00081E] hover:text-crimson transition-colors line-clamp-2">Pameran Karya Akhir Mahasiswa Arsitektur 2024</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-white border border-[#C5C6CF] rounded p-2 text-center min-w-[50px] mr-3 shadow-sm">
                                <div class="text-xs font-bold text-crimson uppercase">NOV</div>
                                <div class="text-lg font-heading font-bold text-[#00081E] leading-none">20</div>
                            </div>
                            <div>
                                <a href="#" class="font-heading font-semibold text-[15px] text-[#00081E] hover:text-crimson transition-colors line-clamp-2">Kompetisi Bola Voli Antar Fakultas</a>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Advertisement Slot -->
                <div class="mb-8">
                    <div class="flex items-center mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-crimson mr-2"></span>
                        <span class="text-xs font-bold text-[#7687B2] uppercase tracking-wider">ADVERTISEMENT</span>
                    </div>
                    <div class="bg-[#EAE7E8] border border-[#C5C6CF] rounded-lg h-[250px] flex items-center justify-center text-[#7687B2]">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest">SPONSOR CONTENT</span>
                        </div>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</main>
@endsection
