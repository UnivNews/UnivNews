@extends('layouts.cms')

@section('title', 'Admin Dashboard - University News')
@section('header_tagline', 'OVERVIEW - UNIVERSITY NEWS CMS')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    {{-- ── Welcome Header ───────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Live Metrics
            </p>
            <h1 class="text-4xl font-extrabold font-heading text-[#00081e] tracking-tight leading-none">Dashboard Overview</h1>
            <p class="text-gray-500 font-sans text-sm mt-2">Welcome back, {{ Auth::guard('admin')->user()->name }} &bull; {{ ucfirst(Auth::guard('admin')->user()->role) }}</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            @if($stats['pending_articles'] > 0)
            <a href="{{ route('admin.articles.index', ['status' => 'pending_review']) }}"
               data-tour="admin-pending-alert"
               class="px-4 py-2.5 bg-amber-50 border border-amber-300 text-amber-800 text-[11px] font-bold uppercase tracking-wider flex items-center gap-2 animate-pulse hover:bg-amber-100 transition-colors">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                {{ $stats['pending_articles'] }} Articles Pending Review
            </a>
            @endif

            <a href="{{ route('admin.articles.create') }}"
               class="px-5 py-2.5 bg-[#00081e] hover:bg-[#8b1528] text-white text-[11px] font-bold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Create New Article
            </a>
        </div>
    </div>

    {{-- ── 4 Stats Cards ─────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" data-tour="admin-stats">

        {{-- Total Articles --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            {{-- Decorative blob --}}
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-gray-100 opacity-60 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Total Articles</span>
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
                <div class="text-[11px] text-gray-400 font-sans">Across all categories</div>
                @endif
            </div>
        </div>

        {{-- Total Views --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-50 opacity-70 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Total Views</span>
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
                <div class="text-[11px] text-gray-400 font-sans">Combined reader traffic</div>
            </div>
        </div>

        {{-- Pending Review --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-amber-50 opacity-70 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Pending</span>
                    <div class="w-8 h-8 flex items-center justify-center bg-amber-50 rounded-sm">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold font-heading text-amber-600 leading-none mb-3">
                    {{ number_format($stats['pending_articles']) }}
                </div>
                <div class="flex items-center gap-1 text-[11px] text-gray-500 font-sans">
                    <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Awaiting review
                </div>
            </div>
        </div>

        {{-- Active Authors --}}
        <div class="relative bg-white border border-gray-200 p-6 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-red-50 opacity-70 group-hover:scale-110 transition-transform duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500">Active Authors</span>
                    <div class="w-8 h-8 flex items-center justify-center bg-red-50 rounded-sm">
                        <svg class="w-4 h-4 text-[#8b1528]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-extrabold font-heading text-[#8b1528] leading-none mb-3">
                    {{ number_format($stats['active_authors']) }}
                </div>
                @if($stats['new_authors_week'] > 0)
                <div class="flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    {{ $stats['new_authors_week'] }} new this week
                </div>
                @else
                <div class="text-[11px] text-gray-400 font-sans">Approved contributors</div>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Publishing Trend Chart ─────────────────────────────────────── --}}
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="admin-chart">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-[#fcfcfd]">
            <div>
                <h2 class="text-base font-bold font-heading text-[#00081e]">Publishing Trends</h2>
                <p class="text-xs text-gray-500 font-sans mt-0.5">Articles published per month — last 12 months</p>
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-500 font-sans">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 inline-block bg-[#4b5563] rounded-sm"></span>
                    Published
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 inline-block bg-[#8b1528] rounded-sm"></span>
                    Highest
                </span>
            </div>
        </div>

        <div class="p-6">
            @php
                $maxCount = collect($trendData)->max('count');
                $maxCount = $maxCount > 0 ? $maxCount : 1; // avoid division by zero
                $chartHeight = 200; // px height of bars area
            @endphp

            {{-- Y-axis grid + bars --}}
            <div class="relative" style="height: {{ $chartHeight + 30 }}px;">

                {{-- Horizontal grid lines --}}
                @php $gridSteps = 4; @endphp
                @for($g = 0; $g <= $gridSteps; $g++)
                    @php $pct = $g / $gridSteps; @endphp
                    <div class="absolute left-8 right-0 flex items-center" style="bottom: {{ 30 + ($chartHeight * $pct) }}px;">
                        <span class="text-[10px] text-gray-400 font-mono w-8 shrink-0 text-right pr-2 -translate-y-1/2 -ml-8 select-none">
                            {{ $maxCount * $pct >= 1 ? (int)round($maxCount * $pct) : ($pct > 0 ? number_format($maxCount * $pct, 1) : 0) }}
                        </span>
                        <div class="flex-1 border-t {{ $g === 0 ? 'border-gray-300' : 'border-gray-100' }} border-dashed"></div>
                    </div>
                @endfor

                {{-- Bars --}}
                <div class="absolute inset-x-8 bottom-[30px] top-0 flex items-end gap-1.5 sm:gap-2">
                    @foreach($trendData as $idx => $point)
                        @php
                            $heightPct = $maxCount > 0 ? ($point['count'] / $maxCount) * 100 : 0;
                            $isMax = $point['count'] === $maxCount && $maxCount > 0;
                            $barColor = $isMax ? '#8b1528' : '#4b5563';
                            $hoverColor = $isMax ? '#721120' : '#374151';
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1 group h-full justify-end" title="{{ $point['label'] }}: {{ $point['count'] }} articles">
                            {{-- Bar --}}
                            <div class="w-full relative rounded-t-sm transition-all duration-500 ease-out cursor-default"
                                 style="height: {{ max($heightPct, $point['count'] > 0 ? 2 : 0) }}%; background-color: {{ $barColor }}; min-height: {{ $point['count'] > 0 ? '4px' : '0' }};"
                                 onmouseenter="this.style.backgroundColor='{{ $hoverColor }}'; this.nextElementSibling.style.opacity='1';"
                                 onmouseleave="this.style.backgroundColor='{{ $barColor }}'; this.nextElementSibling.style.opacity='0';">
                            </div>
                            {{-- Tooltip --}}
                            <div class="absolute bottom-full mb-1.5 left-1/2 -translate-x-1/2 bg-[#00081e] text-white text-[10px] font-bold px-2 py-1 rounded whitespace-nowrap opacity-0 pointer-events-none transition-opacity z-10 shadow-lg">
                                {{ $point['count'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- X-axis labels --}}
            <div class="flex gap-1.5 sm:gap-2 pl-8 mt-1.5">
                @foreach($trendData as $point)
                    <div class="flex-1 text-center text-[10px] text-gray-400 font-sans select-none truncate">
                        {{ $point['short'] }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Recently Added Articles ───────────────────────────────────── --}}
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="admin-articles-table">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-[#fcfcfd]">
            <h2 class="text-base font-bold font-heading text-[#00081e]">Recently Added Articles</h2>
            <a href="{{ route('admin.articles.index') }}"
               class="text-[11px] font-bold text-[#8b1528] hover:text-red-900 transition-colors uppercase tracking-wider">
                View All Articles &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Title</th>
                        <th class="px-6 py-3.5 font-bold">Author</th>
                        <th class="px-6 py-3.5 font-bold">Category</th>
                        <th class="px-6 py-3.5 font-bold">Status</th>
                        <th class="px-6 py-3.5 font-bold">Date</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentArticles as $article)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900 max-w-xs">
                            <span class="line-clamp-1">{{ $article->title }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            @if($article->user->role === 'author')
                                <a href="{{ route('admin.authors.index') }}" class="text-[#8b1528] font-medium hover:underline">
                                    {{ $article->user->preferred_name ?? $article->user->name }}
                                </a>
                            @else
                                {{ $article->user->name ?? 'Unknown' }}
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
                        <td class="px-6 py-4 text-gray-500">
                            {{ $article->created_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($article->isPendingReview())
                                <a href="{{ route('admin.articles.review', $article) }}"
                                   class="text-[#8b1528] font-bold text-[11px] uppercase tracking-wider hover:underline">
                                    Review
                                </a>
                            @else
                                <a href="{{ route('admin.articles.edit', $article) }}"
                                   class="text-gray-500 font-semibold text-[11px] uppercase tracking-wider hover:text-[#00081e]">
                                    Edit
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">No articles found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
