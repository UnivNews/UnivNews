@extends('layouts.cms')

@section('title', 'Manage FAQs — University News')
@section('header_tagline', 'SITE CONTENT - FAQS')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Site Content Management
            </p>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Frequently Asked Questions</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Add, edit, or reorder FAQ entries shown on the Help > FAQ page.</p>
        </div>
        <div>
            <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 bg-crimson hover:bg-red-700 text-white font-heading font-bold text-xs uppercase tracking-wider px-4 py-2.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New FAQ
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-sans text-sm">
                <thead class="bg-navy text-white text-xs uppercase font-heading tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Order</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Question</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($faqs as $faq)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3.5 px-4 font-mono text-gray-500 text-xs">{{ $faq->order }}</td>
                        <td class="py-3.5 px-4 font-medium text-navy">
                            <span class="bg-gray-100 text-gray-700 px-2.5 py-1 text-xs font-semibold rounded">
                                {{ $faq->category ?: 'General' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-medium text-navy max-w-xs truncate" title="{{ $faq->question }}">
                            {{ $faq->question }}
                        </td>
                        <td class="py-3.5 px-4">
                            @if($faq->is_published)
                                <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded font-medium">Published</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-0.5 rounded font-medium">Draft</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right space-x-2">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Edit</a>
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400">
                            No FAQ items found. Click "Add New FAQ" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
