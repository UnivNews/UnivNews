@extends('layouts.public')

@section('title', 'University News - Search Results')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="border-b-4 border-crimson pb-4 mb-12">
        <h1 class="text-3xl font-heading font-extrabold text-navy uppercase tracking-tight">Search Results for: "{{ $query }}"</h1>
        <p class="text-gray-500 mt-2">{{ $articles->total() }} results found</p>
    </div>

    <div class="space-y-8">
        @forelse($articles as $article)
        <a href="{{ route('article', $article->slug) }}" class="block group bg-white shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-md transition-shadow">
            <div class="aspect-video md:w-64 bg-gray-100 relative shrink-0">
                <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-serif italic text-sm">Image</div>
            </div>
            <div class="flex-1">
                <span class="text-crimson font-heading font-bold text-xs uppercase tracking-wider mb-2 block">
                    {{ $article->category->name }}
                </span>
                <h4 class="text-2xl font-serif font-bold text-navy mb-3 group-hover:text-crimson transition-colors duration-200">
                    {{ $article->title }}
                </h4>
                <p class="text-gray-600 mb-4 line-clamp-2">
                    {{ $article->excerpt }}
                </p>
                <div class="text-sm text-gray-500">
                    {{ $article->published_at->format('M j, Y') }} &middot; {{ $article->views_count }} views
                </div>
            </div>
        </a>
        @empty
        <div class="py-12 text-center text-gray-500 bg-gray-50 border border-gray-200">
            <h3 class="text-xl font-heading font-bold text-navy mb-2">No results found</h3>
            <p>Try adjusting your search terms.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $articles->links() }}
    </div>
</div>
@endsection
