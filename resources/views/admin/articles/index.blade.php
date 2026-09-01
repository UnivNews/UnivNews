@extends('layouts.cms')

@section('title', 'Manage Articles - University News')
@section('header_tagline', 'ARTICLE MANAGEMENT - CMS PORTAL')
@section('page_tour_id', 'admin.articles.index')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header & New Article CTA -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Manage Articles</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Review submissions, edit news, and control publishing schedules.</p>
        </div>

        <a href="{{ route('admin.articles.create') }}" data-tour="admin-articles-new-btn" class="px-5 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-bold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Article
        </a>
    </div>

    <!-- Status Tabs Filter Bar -->
    <div class="flex items-center gap-2 border-b border-gray-200 pb-px overflow-x-auto text-xs font-semibold uppercase tracking-wider" data-tour="admin-articles-tabs">
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
        <a href="{{ route('admin.articles.index', ['status' => 'awaiting_payment']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'awaiting_payment' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Awaiting Payment
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
    <div class="bg-white border border-gray-200 p-4 shadow-sm" data-tour="admin-articles-search">
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

    <!-- Articles Table -->
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="admin-articles-table">
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
                    <tr class="hover:bg-gray-50/80 transition-colors cursor-pointer group" onclick="window.location='{{ route('article', $article->slug) }}?ref=admin'">
                        <!-- Title & Excerpt -->
                        <td class="px-6 py-4 max-w-sm">
                            <div class="font-bold text-gray-900 text-sm line-clamp-1 group-hover:text-blue-600 transition-colors">
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
                            <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-700 text-[11px] whitespace-nowrap">
                                {{ $article->category->name ?? '-' }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4">
                            @if($article->status === 'published')
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-800 font-semibold border border-green-200 text-[11px] whitespace-nowrap">Published</span>
                            @elseif($article->status === 'pending_review')
                                <span class="px-2.5 py-0.5 bg-yellow-100 text-yellow-800 font-semibold border border-yellow-300 text-[11px] whitespace-nowrap animate-pulse">Pending Review</span>
                            @elseif($article->status === 'awaiting_payment')
                                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 font-semibold border border-blue-200 text-[11px] whitespace-nowrap">Awaiting Payment</span>
                            @elseif($article->status === 'rejected')
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 font-semibold border border-red-200 text-[11px] whitespace-nowrap">Rejected</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 font-semibold border border-gray-200 text-[11px] whitespace-nowrap">Draft</span>
                            @endif
                        </td>

                        <!-- Views -->
                        <td class="px-6 py-4 text-gray-500 font-medium">
                            {{ number_format($article->views_count) }}
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            {{ $article->created_at->format('M j, Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-end gap-3 flex-nowrap">
                                @if($article->isPendingReview())
                                    <a href="{{ route('admin.articles.review', $article) }}" 
                                       class="text-[#8b1528] hover:text-[#721120] transition-colors" title="Review">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                    </a>
                                @else
                                    <a href="{{ route('admin.articles.edit', $article) }}" 
                                       class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                @endif

                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
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
