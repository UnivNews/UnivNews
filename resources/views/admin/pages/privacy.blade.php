@extends('layouts.cms')

@section('title', 'Edit Privacy Policy — University News')
@section('header_tagline', 'SITE CONTENT - PRIVACY POLICY')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Site Content Management
            </p>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Edit Privacy Policy</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Manage Privacy Policy text displayed to visitors.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.privacy.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-gray-200 shadow-sm p-6 space-y-6">
            <div>
                <label for="content" class="block text-sm font-bold text-navy mb-2">
                    Privacy Policy Text
                </label>
                <p class="text-xs text-gray-500 mb-2">Enter the plain text Privacy Policy. Line breaks will be preserved on the public site.</p>
                <textarea id="content" name="content" rows="12" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans p-3" required>{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-crimson hover:bg-red-700 text-white font-heading font-bold text-xs uppercase tracking-wider px-6 py-3 transition-colors">
                    Save Privacy Policy
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
