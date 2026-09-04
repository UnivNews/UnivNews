@extends('layouts.cms')

@section('title', 'Author Dashboard - University News')
@section('header_tagline', 'AUTHOR DESK - UNIVERSITY NEWS')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    {{-- ── Welcome Header ───────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Author Workspace
            </p>
            <h1 class="text-4xl font-extrabold font-heading text-[#00081e] tracking-tight leading-none">Author Dashboard</h1>
            <p class="text-gray-500 font-sans text-sm mt-2">Welcome back, {{ auth()->user()->preferred_name ?? auth()->user()->name }} &bull; {{ auth()->user()->university->abbreviation ?? auth()->user()->university->name ?? 'University News' }}</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            @if($stats['rejected'] > 0)
            <a href="{{ route('author.articles.index', ['status' => 'rejected']) }}"
               class="px-4 py-2.5 bg-red-50 border border-red-200 text-red-700 text-[11px] font-bold uppercase tracking-wider flex items-center gap-2 hover:bg-red-100 transition-colors">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                {{ $stats['rejected'] }} Action Needed
            </a>
            @endif

            <a href="{{ route('author.articles.create') }}"
               data-tour="author-new-article"
               class="px-5 py-2.5 bg-[#00081e] hover:bg-[#8b1528] text-white text-[11px] font-bold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Write New Article
            </a>
        </div>
    </div>

    {{-- ── 4 Stats Cards (Design Reference Style) ─────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" data-tour="author-stats">

        {{-- Total Articles --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-gray-100 opacity-60 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Total Stories</span>
                    <div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold font-heading text-[#00081e] leading-none mb-3">
                    {{ number_format($stats['total_articles']) }}
                </div>
                @if($stats['article_delta'] !== null)
                <div class="flex items-center gap-1 text-[11px] font-semibold {{ $stats['article_delta'] >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $stats['article_delta'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"/>
                    </svg>
                    {{ abs($stats['article_delta']) }}% this month
                </div>
                @else
                <div class="text-[11px] text-gray-400 font-sans">Created across all topics</div>
                @endif
            </div>
        </div>

        {{-- Total Views / Readers --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-50 opacity-70 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Total Readers</span>
                    <div class="w-8 h-8 flex items-center justify-center bg-blue-50 rounded-sm">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold font-heading text-blue-600 leading-none mb-3">
                    @php
                        $v = $stats['total_views'];
                        echo $v >= 1000 ? number_format($v/1000, 1).'K' : number_format($v);
                    @endphp
                </div>
                <div class="text-[11px] text-gray-400 font-sans">Combined reader impressions</div>
            </div>
        </div>

        {{-- Pending Editorial Review --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-amber-50 opacity-70 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Under Review</span>
                    <div class="w-8 h-8 flex items-center justify-center bg-amber-50 rounded-sm">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold font-heading text-amber-600 leading-none mb-3">
                    {{ number_format($stats['pending_review']) }}
                </div>
                <div class="flex items-center gap-1 text-[11px] text-gray-500 font-sans">
                    <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Awaiting editorial feedback
                </div>
            </div>
        </div>

        {{-- Published Stories --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-emerald-50 opacity-70 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Live Articles</span>
                    <div class="w-8 h-8 flex items-center justify-center bg-emerald-50 rounded-sm">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold font-heading text-emerald-600 leading-none mb-3">
                    {{ number_format($stats['published_articles']) }}
                </div>
                <div class="text-[11px] text-gray-400 font-sans">{{ number_format($stats['drafts']) }} drafts in progress</div>
            </div>
        </div>

    </div>

    {{-- ── My Recent Stories Table ───────────────────────────────────── --}}
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="author-recent-table">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-[#fcfcfd]">
            <div>
                <h2 class="text-base font-bold font-heading text-[#00081e]">My Recent Stories</h2>
                <p class="text-xs text-gray-500 font-sans mt-0.5">Articles and drafts created under your account</p>
            </div>
            <a href="{{ route('author.articles.index') }}" class="text-[11px] font-bold text-[#8b1528] hover:text-red-900 transition-colors uppercase tracking-wider">
                View All &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Title</th>
                        <th class="px-6 py-3.5 font-bold">Category</th>
                        <th class="px-6 py-3.5 font-bold">Status</th>
                        <th class="px-6 py-3.5 font-bold">Views</th>
                        <th class="px-6 py-3.5 font-bold">Last Modified</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentArticles as $article)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 max-w-sm">
                            <div class="font-bold text-gray-900 text-sm line-clamp-1">{{ $article->title }}</div>
                            @if($article->isRejected() && $article->admin_notes)
                                <div class="text-[11px] text-red-700 mt-1.5 font-medium bg-red-50 p-2 border border-red-200">
                                    <strong class="font-bold">Editor Feedback:</strong> {{ $article->admin_notes }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-700 text-[11px] font-medium">
                                {{ $article->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($article->status === 'published')
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-800 font-semibold border border-green-200 text-[11px]">Published</span>
                            @elseif($article->status === 'pending_review')
                                <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 font-semibold border border-amber-300 text-[11px]">Pending Review</span>
                            @elseif($article->status === 'rejected')
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 font-semibold border border-red-200 text-[11px]">Rejected</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 font-semibold border border-gray-200 text-[11px]">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-medium">
                            {{ number_format($article->views_count) }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $article->updated_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($article->isDraft() || $article->isRejected())
                                <a href="{{ route('author.articles.edit', $article) }}" class="text-[#8b1528] font-bold text-[11px] uppercase tracking-wider hover:underline">
                                    Edit
                                </a>
                            @else
                                <a href="{{ route('author.articles.edit', $article) }}" class="text-gray-500 font-semibold text-[11px] uppercase tracking-wider hover:text-[#00081e]">
                                    View
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">You haven't written any articles yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
