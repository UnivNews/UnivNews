@extends('layouts.public')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy tracking-tight">
                Frequently Asked Questions
            </h1>
            <p class="text-gray-500 font-sans text-sm mt-2">Find answers to common questions about University News Portal.</p>
            <div class="w-16 h-1 bg-crimson mx-auto mt-4 rounded-full"></div>
        </div>

        @php
            $allFaqs = $faqs->flatten();
        @endphp

        @if($allFaqs->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center text-gray-500 font-sans">
                No FAQ items found.
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden divide-y divide-gray-100" x-data="{ activeFaq: null }">
                @foreach($allFaqs as $faq)
                <div class="transition-all">
                    <button @click="activeFaq = (activeFaq === {{ $faq->id }} ? null : {{ $faq->id }})" class="w-full text-left px-5 py-4 font-sans font-medium text-sm text-navy flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span>{{ $faq->question }}</span>
                        <svg class="w-4 h-4 text-crimson flex-shrink-0 ml-3 transform transition-transform duration-200" :class="{ 'rotate-180': activeFaq === {{ $faq->id }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="activeFaq === {{ $faq->id }}" x-collapse class="px-5 pb-4 pt-1 border-t border-gray-100 bg-gray-50/50 text-gray-600 font-sans leading-relaxed text-sm">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
