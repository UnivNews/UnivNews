@extends('layouts.cms')

@section('title', 'Boost Article - University News')
@section('header_tagline', 'AUTHOR DESK - UNIVERSITY NEWS')
@section('page_tour_id', 'author.articles.boost')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Boost Article</h1>
        <p class="text-gray-500 font-sans text-sm mt-1">
            "{{ $article->title }}"
        </p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 text-red-700 p-4 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('author.articles.boost.store', $article) }}" id="boostForm">
            @csrf

            <!-- Duration Options -->
            <div class="mb-6" data-tour="boost-duration">
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">1. Pilih Durasi Boost</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($boostPrices as $price)
                        <label class="border border-gray-200 p-4 cursor-pointer hover:border-[#8b1528] transition-colors relative duration-label">
                            <input type="radio" name="duration_type" value="{{ $price->duration_type }}" class="absolute opacity-0" onchange="updateCalendar()" {{ $loop->first ? 'checked' : '' }}>
                            <div class="font-bold text-gray-900">{{ str_replace('_', ' ', Str::title($price->duration_type)) }}</div>
                            <div class="text-sm text-gray-500">{{ $price->duration_days }} Hari</div>
                            <div class="text-[#8b1528] font-extrabold mt-2 text-lg">Rp {{ number_format($price->price, 0, ',', '.') }}</div>
                            <div class="check-icon absolute top-4 right-4 hidden text-[#8b1528]">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Start Date -->
            <div class="mb-6" data-tour="boost-date">
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">2. Pilih Tanggal Mulai</label>
                <p class="text-xs text-gray-500 mb-2">Slot terbatas (Maks 5 artikel per hari). Pilih tanggal yang tersedia.</p>
                <input type="date" name="start_date" id="start_date" min="{{ now()->toDateString() }}" class="border border-gray-300 px-4 py-2 w-full md:w-64 focus:border-[#8b1528] focus:ring-0" required onchange="updateCalendar()">
            </div>

            <!-- Calendar Preview (Simple visual feedback) -->
            <div class="mb-6 bg-gray-50 p-4 border border-gray-200" id="calendarPreview" data-tour="boost-availability" style="display: none;">
                <h3 class="text-sm font-bold text-gray-700 mb-2">Status Ketersediaan:</h3>
                <div id="availabilityStatus" class="font-bold text-lg"></div>
                <div id="slotsStatus" class="text-sm text-gray-600 mt-1"></div>
            </div>

            <hr class="my-6 border-gray-200">

            <div class="flex justify-end gap-3">
                <a href="{{ route('author.articles.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold text-sm uppercase tracking-wider hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" id="submitBtn" data-tour="boost-submit" class="px-5 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                    Lanjut Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    input[type="radio"]:checked + div + div + div + .check-icon {
        display: block;
    }
    input[type="radio"]:checked ~ * {
        /* Styling for checked state can go here */
    }
    .duration-label:has(input:checked) {
        border-color: #8b1528;
        background-color: #fff9fa;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set today as default if empty
        if (!document.getElementById('start_date').value) {
            document.getElementById('start_date').value = '{{ now()->toDateString() }}';
        }
        updateCalendar();
    });

    function updateCalendar() {
        const startDate = document.getElementById('start_date').value;
        const durationType = document.querySelector('input[name="duration_type"]:checked').value;
        
        if (!startDate) return;

        const previewDiv = document.getElementById('calendarPreview');
        const statusDiv = document.getElementById('availabilityStatus');
        const slotsDiv = document.getElementById('slotsStatus');
        const submitBtn = document.getElementById('submitBtn');

        previewDiv.style.display = 'block';
        statusDiv.innerHTML = '<span class="text-gray-500">Mengecek ketersediaan...</span>';
        slotsDiv.innerHTML = '';
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50');

        fetch(`{{ route('author.articles.boost.availability', $article) }}?start_date=${startDate}&duration_type=${durationType}`)
            .then(res => res.json())
            .then(data => {
                // Find the requested start date in the calendar response
                const dayData = data.calendar.find(d => d.date === startDate);
                
                if (dayData) {
                    if (dayData.available) {
                        statusDiv.innerHTML = '<span class="text-green-600">✅ Tersedia</span>';
                        slotsDiv.innerHTML = `Sisa slot pada tanggal ini: ${5 - dayData.slots_taken} dari 5 slot`;
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50');
                    } else {
                        statusDiv.innerHTML = '<span class="text-red-600">❌ Penuh (Tidak Tersedia)</span>';
                        slotsDiv.innerHTML = 'Silakan pilih tanggal mulai yang lain atau durasi yang lebih singkat.';
                    }
                } else {
                    statusDiv.innerHTML = '<span class="text-red-600">❌ Tanggal tidak valid</span>';
                }
            })
            .catch(err => {
                console.error(err);
                statusDiv.innerHTML = '<span class="text-red-600">Terjadi kesalahan saat mengecek data.</span>';
            });
    }
</script>
@endsection
