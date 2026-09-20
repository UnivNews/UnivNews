@extends('layouts.cms')

@section('title', 'App Settings — University News')
@section('header_tagline', 'APP SETTINGS - UNIVERSITY NEWS CMS')
@section('page_tour_id', 'admin.app-settings.index')

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
            <p class="text-gray-500 font-sans text-sm mt-1">Manage UnivNews system configuration.</p>
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
        <p class="font-bold mb-1">There are errors:</p>
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
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="appsettings-publication-fee">

            {{-- Section Header --}}
            <div class="px-6 py-4 border-b border-gray-100 bg-[#00081e] flex items-center gap-3">
                <div class="w-8 h-8 bg-[#8b1528] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider">Payment Configuration</h2>
                    <p class="text-xs text-[#7687B2] mt-0.5">Settings for article publication fees via Mayar.id</p>
                </div>
            </div>

            <div class="p-6 lg:p-8 space-y-6">

                {{-- Publish Fee --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <div class="lg:col-span-4">
                        <label for="publish_fee" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Article Publication Fee
                        </label>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            The amount charged to the author whenever an article is approved and ready to be published.
                            Applies to all new articles after being saved.
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
                                Applies to new invoices
                            </span>
                        </div>
                        @error('publish_fee')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Current active value info --}}
                <div class="bg-[#f8f9fa] border border-gray-200 p-4" data-tour="appsettings-fee-status">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Current Configuration Status</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-[11px] text-gray-500 mb-1">Active Fee</p>
                            <p class="text-lg font-bold text-[#00081e]">
                                Rp {{ number_format($settings['publish_fee']->value ?? 25000, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500 mb-1">Last Modified</p>
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

        {{-- ── Section: Boost Article Prices ────────────────────────────── --}}
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden mt-8" data-tour="appsettings-boost-prices">

            {{-- Section Header --}}
            <div class="px-6 py-4 border-b border-gray-100 bg-[#00081e] flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#8b1528] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Boost Price Configuration</h2>
                        <p class="text-xs text-[#7687B2] mt-0.5">Set prices for article promotion features.</p>
                    </div>
                </div>
                <button type="button" id="add-boost-btn" data-tour="appsettings-add-boost-btn" class="flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-white/20 text-white text-xs font-bold uppercase tracking-wider rounded transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add
                </button>
            </div>

            <div class="p-6 lg:p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm font-sans border border-gray-200">
                        <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider text-xs border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-bold border-r border-gray-200">Duration</th>
                                <th class="px-4 py-3 font-bold border-r border-gray-200">Price (Rp)</th>
                                <th class="px-4 py-3 font-bold text-center border-r border-gray-200" data-tour="appsettings-toggle-switch">Active Status</th>
                                <th class="px-4 py-3 font-bold text-center w-16">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($boostPrices as $bp)
                            <tr>
                                <td class="px-4 py-4 font-medium text-gray-800 border-r border-gray-200 bg-gray-50">
                                    {{ str_replace('_', ' ', Str::title($bp->duration_type)) }}
                                    <span class="block text-xs text-gray-500 font-normal mt-0.5">
                                        ({{ $bp->duration_days }} days)
                                    </span>
                                </td>
                                <td class="px-4 py-3 border-r border-gray-200">
                                    <div class="relative max-w-[200px]">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-500 select-none">Rp</span>
                                        <input
                                             type="number"
                                            name="boost_prices[{{ $bp->id }}][price]"
                                            value="{{ old('boost_prices.'.$bp->id.'.price', $bp->price) }}"
                                            min="0"
                                            step="1000"
                                            required
                                            class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 text-gray-900 text-sm font-mono focus:border-[#8b1528] focus:ring-0 transition-colors"
                                        >
                                    </div>
                                    @error('boost_prices.'.$bp->id.'.price')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-4 py-3 text-center align-middle border-r border-gray-200">
                                    <label class="relative inline-flex items-center cursor-pointer select-none">
                                        <input type="checkbox" name="boost_prices[{{ $bp->id }}][is_active]" value="1" class="sr-only peer" {{ old('boost_prices.'.$bp->id.'.is_active', $bp->is_active) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-300 rounded-full transition-colors duration-200 peer-checked:bg-[#8b1528]"></div>
                                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-transform duration-200 peer-checked:translate-x-5 pointer-events-none"></div>
                                    </label>
                                </td>
                                <td class="px-4 py-3 text-center align-middle">
                                    <button type="button"
                                        data-tour="appsettings-delete-boost-btn"
                                        data-delete-url="{{ route('admin.boost-prices.destroy', $bp->id) }}"
                                        data-package-name="{{ str_replace('_', ' ', Str::title($bp->duration_type)) }} ({{ $bp->duration_days }} days)"
                                        title="Hapus paket ini"
                                        class="delete-boost-btn inline-flex items-center justify-center w-8 h-8 text-red-500 hover:text-white hover:bg-red-600 border border-red-300 hover:border-red-600 rounded transition-colors">
                                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── Note section ────────────────────────────────────────────────── --}}
        <div class="bg-amber-50 border border-amber-200 p-4 flex gap-3" data-tour="appsettings-note">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-amber-800">Attention</p>
                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                    Fee changes <strong>only apply to invoices created after the changes are saved</strong>.
                    Previously created invoices will not be affected.
                    If any authors are currently in the payment process, they will still pay according to the old invoice amount.
                </p>
            </div>
        </div>

        {{-- Save button --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.dashboard') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-600 text-xs font-bold uppercase tracking-wider hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    data-tour="appsettings-save-btn"
                    class="px-8 py-3 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Settings
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

    // Tambah varian boost baru
    let newBoostIndex = 0;
    const addBoostBtn = document.getElementById('add-boost-btn');
    if (addBoostBtn) {
        addBoostBtn.addEventListener('click', function() {
            const tbody = document.querySelector('table tbody');
            const tr = document.createElement('tr');
            tr.className = 'bg-blue-50/30';
            tr.innerHTML = `
                <td class="px-4 py-4 font-medium text-gray-800 border-r border-gray-200">
                    <input type="text" name="new_boost_prices[${newBoostIndex}][duration_type]" placeholder="Name, e.g.: 2_weeks" required class="w-full px-3 py-1.5 border border-gray-300 text-sm focus:border-[#8b1528] focus:ring-0 mb-2">
                    <div class="flex items-center gap-2">
                        <input type="number" name="new_boost_prices[${newBoostIndex}][duration_days]" placeholder="Total" required min="1" class="w-20 px-3 py-1 border border-gray-300 text-xs focus:border-[#8b1528] focus:ring-0">
                        <span class="text-xs text-gray-500">days</span>
                    </div>
                </td>
                <td class="px-4 py-3 border-r border-gray-200 align-top pt-4">
                    <div class="relative max-w-[200px]">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-500 select-none">Rp</span>
                        <input type="number" name="new_boost_prices[${newBoostIndex}][price]" min="0" step="1000" required class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 text-gray-900 text-sm font-mono focus:border-[#8b1528] focus:ring-0 transition-colors">
                    </div>
                </td>
                <td class="px-4 py-3 text-center align-middle border-r border-gray-200">
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="new_boost_prices[${newBoostIndex}][is_active]" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-300 rounded-full transition-colors duration-200 peer-checked:bg-[#8b1528]"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-transform duration-200 peer-checked:translate-x-5 pointer-events-none"></div>
                    </label>
                </td>
                <td class="px-4 py-3 text-center align-middle">
                    <button type="button" class="remove-boost-btn inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-red-600 hover:bg-red-50 border border-gray-300 hover:border-red-300 rounded transition-colors" title="Batal tambah">
                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            newBoostIndex++;
        });
    }

    document.querySelector('table tbody').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-boost-btn') || e.target.closest('.remove-boost-btn')) {
            e.target.closest('tr').remove();
        }
    });

    // Hapus paket boost — gunakan custom Alert Dialog yang seragam dengan halaman CMS lainnya
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-boost-btn');
        if (!btn) return;

        const url = btn.dataset.deleteUrl;
        const packageName = btn.dataset.packageName ? `"${btn.dataset.packageName}"` : 'this boost package';

        const submitDeleteForm = function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.style.display = 'none';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]')?.content
                || document.querySelector('input[name="_token"]')?.value
                || '';

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);

            if (window.showPageLoader) {
                window.showPageLoader('Deleting...');
            }

            form.submit();
        };

        if (typeof window.showAlertDialog === 'function') {
            window.showAlertDialog({
                title: 'Delete boost package?',
                description: `This will permanently delete ${packageName}. This action cannot be undone.`,
                confirmText: 'Delete',
                cancelText: 'Cancel',
                variant: 'destructive',
                icon: 'trash'
            }).then(function(confirmed) {
                if (confirmed) {
                    submitDeleteForm();
                }
            });
        } else if (confirm(`Yakin ingin menghapus paket boost ${packageName}? Tindakan ini tidak bisa dibatalkan.`)) {
            submitDeleteForm();
        }
    });
</script>
@endsection
