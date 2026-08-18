@extends('layouts.public')

@section('title', 'University News - Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Featured Article -->
    @if($featuredArticle)
    <div class="mb-16">
        <a href="{{ route('article', $featuredArticle->slug) }}" class="block group">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white shadow-lg border border-border-main hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-video bg-gray-200 w-full relative">
                    <!-- Placeholder for image -->
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">Featured Image</div>
                </div>
                <div class="p-8">
                    <span class="text-crimson font-heading font-bold text-sm uppercase tracking-wider mb-2 block">
                        {{ $featuredArticle->category->name }}
                    </span>
                    <h2 class="text-4xl font-serif font-bold text-navy mb-4 group-hover:text-crimson transition-colors duration-200">
                        {{ $featuredArticle->title }}
                    </h2>
                    <p class="text-text-main text-lg mb-6 line-clamp-3">
                        {{ $featuredArticle->excerpt }}
                    </p>
                    <div class="text-sm text-gray-500 font-sans">
                        {{ $featuredArticle->published_at->format('F j, Y') }} &middot; By {{ $featuredArticle->user->name }}
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Recent News -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between border-b-2 border-navy pb-2 mb-8">
                <h3 class="text-2xl font-heading font-bold text-navy uppercase">Recent News</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($recentArticles as $article)
                <a href="{{ route('article', $article->slug) }}" class="block group bg-white shadow border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="aspect-video bg-gray-100 relative">
                         <!-- Placeholder for image -->
                    </div>
                    <div class="p-6">
                        <span class="text-crimson font-heading font-bold text-xs uppercase tracking-wider mb-2 block">
                            {{ $article->category->name }}
                        </span>
                        <h4 class="text-xl font-serif font-bold text-navy mb-3 group-hover:text-crimson transition-colors duration-200 line-clamp-2">
                            {{ $article->title }}
                        </h4>
                        <div class="text-sm text-gray-500">
                            {{ $article->published_at->format('M j, Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Trending Search Sidebar -->
        <div>
            <div class="flex items-center justify-between border-b-2 border-crimson pb-2 mb-8">
                <h3 class="text-2xl font-heading font-bold text-navy uppercase">Trending Search</h3>
            </div>
            <div class="space-y-6">
                @foreach($trendingResearch as $index => $article)
                <a href="{{ route('article', $article->slug) }}" class="flex gap-4 group">
                    <span class="text-4xl font-serif font-bold text-gray-200 group-hover:text-crimson transition-colors">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <div>
                        <h4 class="text-md font-serif font-bold text-navy group-hover:text-crimson transition-colors line-clamp-2 mb-1">
                            {{ $article->title }}
                        </h4>
                        <span class="text-xs text-gray-500">{{ $article->published_at->format('M j, Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
