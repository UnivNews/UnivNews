@extends('layouts.cms')

@section('title', 'Manage Articles - University News')
@section('header_tagline', 'ARTICLE MANAGEMENT - CMS PORTAL')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header & New Article CTA -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Manage Articles</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Review submissions, edit news, and control publishing schedules.</p>
        </div>

        <a href="{{ route('admin.articles.create') }}" class="px-5 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-bold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Article
        </a>
    </div>

    <!-- Status Tabs Filter Bar -->
    <div class="flex items-center gap-2 border-b border-gray-200 pb-px overflow-x-auto text-xs font-semibold uppercase tracking-wider">
        @php
            $currentStatus = request('status');
        @endphp
        <a href="{{ route('admin.articles.index') }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ empty($currentStatus) ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            All Articles
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'pending_review']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'pending_review' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Pending Review
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'published']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'published' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Published
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'draft' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Drafts
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'rejected' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Rejected
        </a>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white border border-gray-200 p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
            @if($currentStatus)
                <input type="hidden" name="status" value="{{ $currentStatus }}">
            @endif

            <div class="sm:col-span-6">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search title, author, or keyword..." 
                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
            </div>

            <div class="sm:col-span-4">
                <select name="category" class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 bg-gray-800 hover:bg-black text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Filter
                </button>
                @if(request('search') || request('category') || request('status'))
                    <a href="{{ route('admin.articles.index') }}" class="p-2 border border-gray-300 text-gray-500 hover:text-red-700" title="Reset Filters">
                        &times;
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Articles Table Card -->
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Article</th>
                        <th class="px-6 py-3.5 font-bold">Author</th>
                        <th class="px-6 py-3.5 font-bold">Category</th>
                        <th class="px-6 py-3.5 font-bold">Status</th>
                        <th class="px-6 py-3.5 font-bold">Views</th>
                        <th class="px-6 py-3.5 font-bold">Date</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($articles as $article)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <!-- Title & Excerpt -->
                        <td class="px-6 py-4 max-w-sm">
                            <div class="font-bold text-gray-900 text-sm line-clamp-1">
                                {{ $article->title }}
                            </div>
                            <div class="text-[11px] text-gray-400 mt-0.5 line-clamp-1 font-serif-content">
                                {{ $article->excerpt ?? 'No excerpt available.' }}
                            </div>
                        </td>

                        <!-- Author -->
                        <td class="px-6 py-4 text-gray-700">
                            <div class="font-medium">{{ $article->user->name ?? 'Unknown' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $article->user->university->abbreviation ?? '' }}</div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 text-gray-600">
                            <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-700 text-[11px]">
                                {{ $article->category->name ?? '-' }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4">
                            @if($article->status === 'published')
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-800 font-semibold border border-green-200 text-[11px]">Published</span>
                            @elseif($article->status === 'pending_review')
                                <span class="px-2.5 py-0.5 bg-yellow-100 text-yellow-800 font-semibold border border-yellow-300 text-[11px] animate-pulse">Pending Review</span>
                            @elseif($article->status === 'rejected')
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 font-semibold border border-red-200 text-[11px]">Rejected</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 font-semibold border border-gray-200 text-[11px]">Draft</span>
                            @endif
                        </td>

                        <!-- Views -->
                        <td class="px-6 py-4 text-gray-500 font-medium">
                            {{ number_format($article->views_count) }}
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-gray-500">
                            {{ $article->created_at->format('M j, Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($article->isPendingReview())
                                <a href="{{ route('admin.articles.review', $article) }}" 
                                   class="px-2.5 py-1 bg-[#8b1528] text-white hover:bg-[#721120] text-[11px] font-bold uppercase tracking-wider inline-block">
                                    Review
                                </a>
                            @else
                                <a href="{{ route('admin.articles.edit', $article) }}" 
                                   class="text-gray-700 font-semibold hover:text-[#00081e]">
                                    Edit
                                </a>
                            @endif

                            <a href="{{ route('article', $article->slug) }}" target="_blank" class="text-blue-600 font-semibold hover:underline">
                                View
                            </a>

                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">No articles found matching criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
        <div class="p-4 border-t border-gray-200 bg-[#f8f9fa]">
            {{ $articles->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
