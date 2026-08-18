@extends('layouts.public')

@section('title', $article->title . ' - University News')

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <header class="mb-10 text-center">
        <a href="{{ route('category', $article->category->slug) }}" class="text-crimson font-heading font-bold text-sm uppercase tracking-wider hover:underline mb-4 inline-block">
            {{ $article->category->name }}
        </a>
        <h1 class="text-4xl md:text-6xl font-serif font-bold text-navy leading-tight mb-6">
            {{ $article->title }}
        </h1>
        <div class="text-gray-600 font-sans flex items-center justify-center space-x-4">
            <span class="font-medium text-navy">By {{ $article->user->name }} @if($article->user->university) ({{ $article->user->university->abbreviation ?? $article->user->university->name }}) @endif</span>
            <span>&bull;</span>
            <span>{{ $article->published_at->format('F j, Y') }}</span>
            <span>&bull;</span>
            <span>{{ $article->views_count }} Views</span>
        </div>
    </header>

    <!-- Featured Image -->
    @if($article->featured_image_path)
    <div class="aspect-video bg-gray-100 w-full relative mb-12 shadow-md overflow-hidden border border-border-main">
        <img src="{{ asset($article->featured_image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
    </div>
    @endif

    <!-- Content -->
    <div class="prose prose-lg prose-blue max-w-none font-serif text-gray-800 leading-relaxed mb-12">
        {!! $article->content !!}
    </div>

    <!-- Tags -->
    @if($article->tags->count() > 0)
    <div class="border-t border-b border-gray-200 py-4 mb-12 flex items-center gap-4 flex-wrap">
        <span class="font-heading font-bold text-navy uppercase text-sm">Tags:</span>
        @foreach($article->tags as $tag)
            <span class="bg-gray-100 text-gray-700 px-3 py-1 text-sm font-sans rounded-full">{{ $tag->name }}</span>
        @endforeach
    </div>
    @endif

    <!-- Related Articles -->
    @if($relatedArticles->count() > 0)
    <div class="mt-16 bg-gray-50 p-8 border border-gray-200">
        <h3 class="text-2xl font-heading font-bold text-navy uppercase mb-8 border-b-2 border-navy pb-2 inline-block">Related Reading</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedArticles as $related)
            <a href="{{ route('article', $related->slug) }}" class="block group">
                <div class="aspect-[3/2] bg-gray-200 relative mb-4"></div>
                <h4 class="font-serif font-bold text-navy text-lg group-hover:text-crimson transition-colors line-clamp-2 mb-2">
                    {{ $related->title }}
                </h4>
                <div class="text-xs text-gray-500">{{ $related->published_at->format('M j, Y') }}</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</article>
@endsection
