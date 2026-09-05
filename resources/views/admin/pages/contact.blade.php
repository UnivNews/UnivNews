@extends('layouts.cms')

@section('title', 'Edit Contact Info — University News')
@section('header_tagline', 'SITE CONTENT - CONTACT INFO')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Site Content Management
            </p>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Edit Contact Info</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Manage contact information displayed on the public Contact page.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-red-600 text-red-700 text-sm">
        <p class="font-bold mb-1">Please fix the following errors:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.contact.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-gray-200 shadow-sm p-6 space-y-6">
            <div>
                <label for="contact_whatsapp" class="block text-sm font-bold text-navy mb-1">
                    WhatsApp Support Number
                </label>
                <p class="text-xs text-gray-500 mb-2">Format: international number starting with country code e.g. +6281234567890.</p>
                <input type="text" id="contact_whatsapp" name="contact_whatsapp" value="{{ old('contact_whatsapp', $whatsapp) }}" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans px-3 py-2" required>
            </div>

            <div>
                <label for="contact_email" class="block text-sm font-bold text-navy mb-1">
                    Support Email Address
                </label>
                <p class="text-xs text-gray-500 mb-2">Primary contact email address.</p>
                <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $email) }}" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans px-3 py-2" required>
            </div>

            <div>
                <label for="contact_address" class="block text-sm font-bold text-navy mb-1">
                    Physical Office Address
                </label>
                <p class="text-xs text-gray-500 mb-2">Headquarters or main office address.</p>
                <textarea id="contact_address" name="contact_address" rows="4" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans p-3" required>{{ old('contact_address', $address) }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-crimson hover:bg-red-700 text-white font-heading font-bold text-xs uppercase tracking-wider px-6 py-3 transition-colors">
                    Save Contact Info
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
