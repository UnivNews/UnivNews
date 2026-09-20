@extends('layouts.cms')

@section('title', 'Edit About Us — University News')
@section('header_tagline', 'SITE CONTENT - ABOUT US')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Site Content Management
            </p>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Edit About Us</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Manage platform overview, vision, and mission content.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.about.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-gray-200 shadow-sm p-6 space-y-6">
            <div>
                <label for="content" class="block text-sm font-bold text-navy mb-2">
                    Description / Profile
                </label>
                <p class="text-xs text-gray-500 mb-2">Main text explaining what UnivNews is and how it works.</p>
                <textarea id="content" name="content" rows="6" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans p-3">{{ old('content', $page->content) }}</textarea>
            </div>

            <div>
                <label for="vision" class="block text-sm font-bold text-navy mb-2">
                    Vision Statement
                </label>
                <p class="text-xs text-gray-500 mb-2">High-level vision statement of the platform.</p>
                <textarea id="vision" name="vision" rows="3" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans p-3">{{ old('vision', $page->vision) }}</textarea>
            </div>

            <div>
                <label for="mission" class="block text-sm font-bold text-navy mb-2">
                    Mission Items (One per line)
                </label>
                <p class="text-xs text-gray-500 mb-2">Enter each mission bullet point on a separate line.</p>
                <textarea id="mission" name="mission" rows="5" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans p-3">{{ old('mission', $page->mission) }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-crimson hover:bg-red-700 text-white font-heading font-bold text-xs uppercase tracking-wider px-6 py-3 transition-colors">
                    Save About Us
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
