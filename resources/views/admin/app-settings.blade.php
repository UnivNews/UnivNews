@extends('layouts.cms')

@section('title', 'App Settings — University News')
@section('header_tagline', 'APP SETTINGS - UNIVERSITY NEWS CMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                System Configuration
            </p>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">App Settings</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Kelola konfigurasi sistem UnivNews.</p>
        </div>
    </div>

    {{-- Success / Error Alerts --}}
    @if(session('success'))
    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-red-600 text-red-700 text-sm">
        <p class="font-bold mb-1">Terdapat kesalahan:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.app-settings.update') }}" id="app-settings-form">
        @csrf
        @method('PUT')

        {{-- ── Section: Payment Configuration ────────────────────────────── --}}
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">

            {{-- Section Header --}}
            <div class="px-6 py-4 border-b border-gray-100 bg-[#00081e] flex items-center gap-3">
                <div class="w-8 h-8 bg-[#8b1528] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider">Konfigurasi Pembayaran</h2>
                    <p class="text-xs text-[#7687B2] mt-0.5">Pengaturan biaya publish artikel via Mayar.id</p>
                </div>
            </div>

            <div class="p-6 lg:p-8 space-y-6">

                {{-- Publish Fee --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <div class="lg:col-span-4">
                        <label for="publish_fee" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Biaya Publish Artikel
                        </label>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Nominal yang ditagih ke author setiap kali artikel disetujui dan ingin dipublikasikan.
                            Berlaku untuk semua artikel baru setelah disimpan.
                        </p>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-500 select-none">Rp</span>
                            <input
                                type="number"
                                name="publish_fee"
                                id="publish_fee"
                                value="{{ old('publish_fee', $settings['publish_fee']->value ?? 25000) }}"
                                min="1000"
                                max="10000000"
                                step="1000"
                                required
                                class="w-full pl-10 pr-4 py-3 bg-[#f8f9fa] border border-gray-300 text-gray-900 text-sm font-mono focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0 transition-colors"
                                placeholder="25000"
                            >
                        </div>
                        {{-- Live preview --}}
                        <div class="mt-2 flex items-center gap-3">
                            <p class="text-xs text-gray-500">
                                Preview:
                                <span id="fee-preview" class="font-bold text-[#00081e]">
                                    Rp {{ number_format($settings['publish_fee']->value ?? 25000, 0, ',', '.') }}
                                </span>
                            </p>
                            <span class="text-[10px] px-2 py-0.5 bg-amber-100 text-amber-700 font-semibold uppercase tracking-wider">
                                Berlaku untuk invoice baru
                            </span>
                        </div>
                        @error('publish_fee')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Current active value info --}}
                <div class="bg-[#f8f9fa] border border-gray-200 p-4">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Status Konfigurasi Saat Ini</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-[11px] text-gray-500 mb-1">Biaya Aktif</p>
                            <p class="text-lg font-bold text-[#00081e]">
                                Rp {{ number_format($settings['publish_fee']->value ?? 25000, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500 mb-1">Terakhir Diubah</p>
                            <p class="text-sm font-medium text-gray-700">
                                {{ isset($settings['publish_fee']) ? $settings['publish_fee']->updated_at->diffForHumans() : 'Default' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500 mb-1">Gateway</p>
                            <p class="text-sm font-medium text-gray-700">Mayar.id</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Note section ────────────────────────────────────────────────── --}}
        <div class="bg-amber-50 border border-amber-200 p-4 flex gap-3">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-amber-800">Perhatian</p>
                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                    Perubahan biaya <strong>hanya berlaku untuk invoice yang dibuat setelah perubahan disimpan</strong>.
                    Invoice yang sudah terbuat sebelumnya tidak akan terpengaruh.
                    Jika ada author yang sedang dalam proses pembayaran, mereka akan tetap membayar sesuai nominal invoice lama.
                </p>
            </div>
        </div>

        {{-- Save button --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.dashboard') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>

    </form>

</div>

<script>
    // Live preview biaya saat mengetik
    document.getElementById('publish_fee').addEventListener('input', function () {
        const val = parseInt(this.value.replace(/\D/g, ''), 10) || 0;
        document.getElementById('fee-preview').textContent =
            'Rp ' + val.toLocaleString('id-ID');
    });
</script>
@endsection
