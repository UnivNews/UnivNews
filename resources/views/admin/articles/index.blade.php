@extends('layouts.admin')

@section('title', 'Manage Articles - University News')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-heading font-bold text-navy">Manage Articles</h2>
        <p class="text-gray-600 mt-1">Create, edit, and manage news content.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="bg-crimson hover:bg-red-700 text-white px-6 py-2.5 font-heading font-bold text-sm uppercase tracking-wider transition-colors inline-flex items-center shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        New Article
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 mb-6 flex items-center">
    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white shadow-sm border border-border-main">
    <div class="overflow-x-auto">
        <table class="w-full text-left font-sans text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b border-border-main">
                <tr>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Title</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Author</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Category</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Status</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Date</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-main">
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-navy mb-1 line-clamp-1">{{ $article->title }}</div>
                        <div class="text-gray-500 text-xs">{{ $article->views_count }} views</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $article->user->name }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        <span class="bg-gray-100 text-gray-600 px-2 py-1 text-xs">{{ $article->category->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($article->status === 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $article->created_at->format('M j, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('article', $article->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-xs uppercase tracking-wider" title="View Public">
                            View
                        </a>
                        @can('update', $article)
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-navy hover:text-crimson font-medium text-xs uppercase tracking-wider">
                            Edit
                        </a>
                        @endcan
                        @can('delete', $article)
                        <form action="{{ route('admin.articles.delete', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this article?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs uppercase tracking-wider">
                                Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg">No articles found.</p>
                        <p class="text-sm mt-1">Get started by creating a new article.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-border-main bg-gray-50">
        {{ $articles->links() }}
    </div>
</div>
@endsection
