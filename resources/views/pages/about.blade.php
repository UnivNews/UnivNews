@extends('layouts.public')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy tracking-tight">
                {{ $page->title ?? 'About Us' }}
            </h1>
            <div class="w-16 h-1 bg-crimson mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 mb-8 space-y-8">
            <!-- Platform Overview -->
            <div>
                <h2 class="font-heading font-bold text-xl text-navy mb-4">Who We Are</h2>
                <div class="text-gray-700 font-sans leading-relaxed space-y-4">
                    {!! nl2br(e($page->content ?? 'University News Portal provides authoritative reporting and intellectual discourse for the academic community.')) !!}
                </div>
            </div>

            @if(!empty($page->vision))
            <hr class="border-gray-100">
            <!-- Vision -->
            <div>
                <h2 class="font-heading font-bold text-xl text-navy mb-4">Our Vision</h2>
                <p class="text-gray-700 font-sans leading-relaxed bg-red-50/50 border-l-4 border-crimson p-4 rounded-r">
                    {!! nl2br(e($page->vision)) !!}
                </p>
            </div>
            @endif

            @if(!empty($page->mission))
            <hr class="border-gray-100">
            <!-- Mission -->
            <div>
                <h2 class="font-heading font-bold text-xl text-navy mb-4">Our Mission</h2>
                <ul class="space-y-3">
                    @foreach(explode("\n", $page->mission) as $missionItem)
                        @if(trim($missionItem) !== '')
                        <li class="flex items-start text-gray-700 font-sans">
                            <span class="w-2 h-2 bg-crimson rounded-full mt-2 mr-3 shrink-0"></span>
                            <span>{{ trim($missionItem) }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
