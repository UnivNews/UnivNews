@extends('layouts.admin')

@section('title', 'Admin Dashboard - University News')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-heading font-bold text-navy">Dashboard Overview</h2>
    <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 shadow-sm border border-border-main">
        <h3 class="text-gray-500 font-sans text-sm font-semibold uppercase tracking-wider mb-2">Total Articles</h3>
        <p class="text-3xl font-serif font-bold text-navy">{{ $stats['total_articles'] }}</p>
    </div>
    <div class="bg-white p-6 shadow-sm border border-border-main border-l-4 border-l-green-500">
        <h3 class="text-gray-500 font-sans text-sm font-semibold uppercase tracking-wider mb-2">Published</h3>
        <p class="text-3xl font-serif font-bold text-green-600">{{ $stats['published_articles'] }}</p>
    </div>
    <div class="bg-white p-6 shadow-sm border border-border-main border-l-4 border-l-yellow-500">
        <h3 class="text-gray-500 font-sans text-sm font-semibold uppercase tracking-wider mb-2">Drafts</h3>
        <p class="text-3xl font-serif font-bold text-yellow-600">{{ $stats['drafts'] }}</p>
    </div>
    <div class="bg-white p-6 shadow-sm border border-border-main border-l-4 border-l-crimson">
        <h3 class="text-gray-500 font-sans text-sm font-semibold uppercase tracking-wider mb-2">Total Views</h3>
        <p class="text-3xl font-serif font-bold text-crimson">{{ number_format($stats['total_views']) }}</p>
    </div>
</div>

<!-- Recent Articles -->
<div class="bg-white shadow-sm border border-border-main">
    <div class="px-6 py-4 border-b border-border-main flex justify-between items-center bg-gray-50">
        <h3 class="text-lg font-heading font-bold text-navy">Recently Added Articles</h3>
        <a href="{{ route('admin.articles') }}" class="text-crimson hover:text-red-700 font-sans font-medium text-sm">View All &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left font-sans text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b border-border-main">
                <tr>
                    <th class="px-6 py-3 font-semibold">Title</th>
                    <th class="px-6 py-3 font-semibold">Author</th>
                    <th class="px-6 py-3 font-semibold">Category</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-main">
                @forelse($recentArticles as $article)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-navy">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="hover:text-crimson transition-colors">
                            {{ Str::limit($article->title, 50) }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $article->user->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $article->category->name }}</td>
                    <td class="px-6 py-4">
                        @if($article->status === 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $article->created_at->format('M j, Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No articles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
