@extends('layouts.public')

@section('title', 'University News - ' . $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="border-b-4 border-crimson pb-4 mb-12">
        <h1 class="text-5xl font-heading font-extrabold text-navy uppercase tracking-tight">{{ $category->name }}</h1>
    </div>

    @if(isset($featuredResearch) && $featuredResearch)
    <div class="mb-16">
        <a href="{{ route('article', $featuredResearch->slug) }}" class="block group">
            <div class="relative h-[500px] w-full overflow-hidden bg-gray-900">
                <div class="absolute inset-0 bg-navy/60 group-hover:bg-navy/40 transition-colors duration-300 z-10"></div>
                <div class="absolute bottom-0 left-0 p-8 md:p-12 z-20 max-w-4xl">
                    <span class="bg-crimson text-white font-heading font-bold text-sm uppercase tracking-wider px-3 py-1 mb-4 inline-block">
                        Featured Highlight
                    </span>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4 leading-tight">
                        {{ $featuredResearch->title }}
                    </h2>
                    <p class="text-gray-200 text-lg mb-6 line-clamp-2 md:line-clamp-3">
                        {{ $featuredResearch->excerpt }}
                    </p>
                    <div class="text-sm text-gray-300 font-sans">
                        {{ $featuredResearch->published_at->format('F j, Y') }} &middot; By {{ $featuredResearch->user->name }}
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
        <a href="{{ route('article', $article->slug) }}" class="block group flex flex-col h-full bg-white shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-serif italic text-sm">Image</div>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h4 class="text-xl font-serif font-bold text-navy mb-3 group-hover:text-crimson transition-colors duration-200 line-clamp-3">
                    {{ $article->title }}
                </h4>
                <p class="text-gray-600 mb-4 line-clamp-3 flex-1">
                    {{ Str::limit($article->excerpt, 120) }}
                </p>
                <div class="text-sm text-gray-500 border-t border-gray-100 pt-4 mt-auto">
                    {{ $article->published_at->format('M j, Y') }} &middot; {{ $article->views_count }} views
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $articles->links() }}
    </div>
</div>
@endsection
