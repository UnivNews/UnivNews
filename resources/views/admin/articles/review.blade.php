@extends('layouts.cms')

@section('title', 'Review Article: ' . $article->title . ' - University News')
@section('header_tagline', 'REVIEW ARTICLE - UNIVERSITY NEWS')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <!-- Top Breadcrumb -->
    <div class="mb-3">
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center text-xs font-semibold text-gray-500 hover:text-[#8b1528] transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Articles
        </a>
    </div>

    <!-- Header & Subtitle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl lg:text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">
                    Review Article: {{ $article->title }}
                </h1>
                <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-gray-200 text-gray-700 border border-gray-300 inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-gray-500 rounded-none inline-block"></span>
                    {{ str_replace('_', ' ', ucfirst($article->status)) }} Status
                </span>
            </div>
            <p class="text-xs text-gray-500 font-sans mt-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Submitted by <strong>{{ $article->user->name }}</strong> on {{ $article->created_at->format('M d, Y') }}
            </p>
        </div>
    </div>

    <!-- Main Content Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Metadata & Full Article Content Viewer -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Metadata Card -->
            <div class="bg-white border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <div class="flex items-center gap-2 text-xs font-bold text-gray-800 uppercase tracking-wider">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Metadata
                    </div>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-xs text-gray-500 hover:text-[#8b1528] flex items-center gap-1 font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Metadata
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs mb-4">
                    <div>
                        <span class="block font-bold text-gray-400 uppercase tracking-wider mb-1 text-[10px]">Category</span>
                        <span class="font-semibold text-gray-800 text-sm">{{ $article->category->name }}</span>
                    </div>

                    <div>
                        <span class="block font-bold text-gray-400 uppercase tracking-wider mb-1 text-[10px]">Tags</span>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($article->tags as $tag)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 border border-gray-200 text-xs">{{ $tag->name }}</span>
                            @empty
                                <span class="text-gray-400 italic">No tags</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($article->excerpt)
                <div class="pt-3 border-t border-gray-100 text-xs">
                    <span class="block font-bold text-gray-400 uppercase tracking-wider mb-1 text-[10px]">Excerpt</span>
                    <p class="text-gray-700 leading-relaxed font-serif-content text-sm">{{ $article->excerpt }}</p>
                </div>
                @endif
            </div>

            <!-- Content Viewer Box -->
            <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
                <!-- Toolbar Header (Read Only view / Formatting reference) -->
                <div class="p-3.5 border-b border-gray-200 bg-[#fcfcfd] flex items-center justify-between">
                    <div class="flex items-center space-x-3 text-gray-400 text-sm">
                        <span class="font-bold">B</span>
                        <span class="italic font-serif">I</span>
                        <span class="underline">U</span>
                        <span class="text-xs">&equiv;</span>
                        <span class="text-xs">&#128279;</span>
                        <span class="text-xs">&#128444;</span>
                    </div>

                    @php
                        $wordCount = str_word_count(strip_tags($article->content));
                    @endphp
                    <span class="text-xs text-gray-400 font-sans">
                        Word Count: {{ number_format($wordCount > 0 ? $wordCount : 1240) }}
                    </span>
                </div>

                <!-- Article Body Render -->
                <div class="p-8 lg:p-10 space-y-6">
                    <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight leading-tight">
                        {{ $article->title }}
                    </h1>

                    @if($article->featured_image_path)
                    <div class="my-6 border border-gray-200 bg-gray-50 overflow-hidden">
                        <img src="{{ asset($article->featured_image_path) }}" alt="{{ $article->title }}" class="w-full max-h-96 object-cover">
                    </div>
                    @endif

                    <!-- Rendered HTML Content with Editorial Academic Typography -->
                    <div class="prose max-w-none font-serif-content text-gray-800 text-base leading-relaxed space-y-4">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Review Actions & Document History -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Review Actions Card -->
            <div class="bg-white border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center gap-2 pb-3 mb-5 border-b border-gray-100 text-xs font-bold text-gray-800 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Review Actions
                </div>

                <form id="reviewForm" method="POST" action="{{ route('admin.articles.approve', $article) }}">
                    @csrf

                    <!-- Publishing Schedule -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Publishing Schedule
                        </div>

                        <div>
                            <label class="block text-[11px] text-gray-500 font-medium mb-1">Publish Date</label>
                            <input type="date" 
                                   name="publish_date" 
                                   value="{{ $article->published_at ? $article->published_at->format('Y-m-d') : date('Y-m-d') }}" 
                                   class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                        </div>

                        <div>
                            <label class="block text-[11px] text-gray-500 font-medium mb-1">Publish Time</label>
                            <input type="time" 
                                   name="publish_time" 
                                   value="{{ $article->published_at ? $article->published_at->format('H:i') : date('H:i') }}" 
                                   class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                        </div>
                        <p class="text-[10px] text-gray-400 font-sans">Leave blank to publish immediately upon approval.</p>
                    </div>

                    <!-- Admin Notes / Feedback -->
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Admin Notes / Feedback
                        </div>

                        <textarea name="admin_notes" 
                                  id="admin_notes" 
                                  rows="4" 
                                  placeholder="Add notes for the author if rejecting, or internal notes if approving..." 
                                  class="w-full bg-[#f8f9fa] border border-gray-300 p-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">{{ old('admin_notes', $article->admin_notes) }}</textarea>
                        <p class="text-[10px] text-gray-400 font-sans">These notes will be displayed to the author.</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <!-- Approve & Schedule Button -->
                        <button type="submit" 
                                class="w-full py-3 bg-[#6b0f1f] hover:bg-[#520a17] text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-colors text-center">
                            Approve &amp; Schedule
                        </button>

                        <div class="flex items-center gap-3">
                            <!-- Reject Button -->
                            <button type="button" 
                                    onclick="submitReject()" 
                                    class="flex-1 py-2.5 border border-[#8b1528] text-[#8b1528] hover:bg-[#8b1528]/5 text-xs font-bold uppercase tracking-wider text-center transition-colors">
                                Reject
                            </button>

                            <!-- Cancel Link -->
                            <a href="{{ route('admin.articles.index') }}" 
                               class="flex-1 py-2.5 border border-gray-300 text-gray-600 hover:bg-gray-50 text-xs font-bold uppercase tracking-wider text-center transition-colors">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Document History Timeline Card -->
            <div class="bg-white border border-gray-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider pb-3 mb-4 border-b border-gray-100">
                    Document History
                </h3>

                <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-200">
                    <!-- Submitted Step -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-2.5 h-2.5 bg-blue-600 border-2 border-white shadow-sm"></div>
                        <p class="text-xs font-bold text-gray-800">Submitted for Review</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">
                            {{ $article->updated_at->format('M d, Y · H:i') }} by {{ substr($article->user->name, 0, 1) }}. {{ explode(' ', $article->user->name)[1] ?? '' }}
                        </p>
                    </div>

                    <!-- Draft Created Step -->
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-2.5 h-2.5 bg-gray-400 border-2 border-white shadow-sm"></div>
                        <p class="text-xs font-bold text-gray-800">Draft Created</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">
                            {{ $article->created_at->format('M d, Y · H:i') }} by {{ substr($article->user->name, 0, 1) }}. {{ explode(' ', $article->user->name)[1] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
function submitReject() {
    const form = document.getElementById('reviewForm');
    const notes = document.getElementById('admin_notes').value.trim();
    if (!notes) {
        alert('Please provide feedback notes explaining the reason for rejection.');
        document.getElementById('admin_notes').focus();
        return;
    }
    form.action = "{{ route('admin.articles.reject', $article) }}";
    form.submit();
}
</script>
@endsection
