@extends('layouts.public')

@section('content')
<div class="bg-gray-50 min-h-screen py-12 sm:py-16">
    <!-- Narrower, centered container -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10">
            <!-- Title -->
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy tracking-tight mb-6 border-b border-gray-100 pb-4">
                {{ $page->title ?? 'Kebijakan Privasi' }}
            </h1>

            <!-- Inner Privacy Content -->
            <div class="space-y-6 text-gray-700 font-sans leading-relaxed text-sm sm:text-base">
                @php
                    $rawContent = trim($page->content ?? '');
                    // Separate by double line break into sections
                    $blocks = preg_split('/\n\s*\n/', $rawContent);
                @endphp

                @foreach($blocks as $block)
                    @php
                        $lines = array_values(array_filter(array_map('trim', explode("\n", $block))));
                        if (empty($lines)) continue;
                        $firstLine = $lines[0];
                        $isBulletList = str_starts_with($firstLine, '-') || str_starts_with($firstLine, '•');
                        $isHeading = count($lines) == 1 && !$isBulletList && strlen($firstLine) < 70 && !str_ends_with($firstLine, '.');
                    @endphp

                    @if($isHeading)
                        <h2 class="font-heading font-bold text-lg sm:text-xl text-navy mt-6 mb-2">{{ $firstLine }}</h2>
                    @elseif($isBulletList)
                        <ul class="list-disc pl-5 space-y-2 text-gray-700 my-2">
                            @foreach($lines as $line)
                                <li>{{ ltrim($line, '-• ') }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="space-y-2">
                            @foreach($lines as $line)
                                @if(str_starts_with($line, '-') || str_starts_with($line, '•'))
                                    <ul class="list-disc pl-5 space-y-1 text-gray-700 my-1">
                                        <li>{{ ltrim($line, '-• ') }}</li>
                                    </ul>
                                @else
                                    <p class="leading-relaxed">
                                        @if(str_contains($line, 'Kontak Kami'))
                                            {!! str_replace('Kontak Kami', '<a href="'.route('page.contact').'" class="text-crimson hover:underline font-medium">Kontak Kami</a>', e($line)) !!}
                                        @elseif(str_contains($line, 'Contact Us'))
                                            {!! str_replace('Contact Us', '<a href="'.route('page.contact').'" class="text-crimson hover:underline font-medium">Contact Us</a>', e($line)) !!}
                                        @else
                                            {{ $line }}
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

    </div>
</div>
@endsection
