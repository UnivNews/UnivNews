@extends('layouts.cms')

@section('title', 'Create FAQ — University News')
@section('header_tagline', 'SITE CONTENT - CREATE FAQ')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8b1528] flex items-center gap-1.5 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1528] inline-block"></span>
                Site Content Management
            </p>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Create FAQ Item</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Add a new question and answer to the FAQ list.</p>
        </div>
        <div>
            <a href="{{ route('admin.faqs.index') }}" class="text-gray-600 hover:text-navy text-xs font-heading font-bold uppercase tracking-wider">
                &larr; Back to FAQ List
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-red-600 text-red-700 text-sm">
        <p class="font-bold mb-1">Please fix the following errors:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white border border-gray-200 shadow-sm p-6 space-y-6">
            <div>
                <label for="category" class="block text-sm font-bold text-navy mb-1">
                    Category
                </label>
                <select id="category" name="category" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans px-3 py-2" required>
                    @foreach(['General', 'Readers', 'Authors', 'Payments', 'Technical'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="question" class="block text-sm font-bold text-navy mb-1">
                    Question
                </label>
                <input type="text" id="question" name="question" value="{{ old('question') }}" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans px-3 py-2" required placeholder="e.g. How can I apply to become an author?">
            </div>

            <div>
                <label for="answer" class="block text-sm font-bold text-navy mb-1">
                    Answer
                </label>
                <textarea id="answer" name="answer" rows="6" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans p-3" required placeholder="Provide clear, concise answer text here...">{{ old('answer') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="order" class="block text-sm font-bold text-navy mb-1">
                        Display Order
                    </label>
                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}" class="w-full border border-gray-300 focus:border-crimson focus:ring-0 text-sm font-sans px-3 py-2" min="0">
                </div>

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-crimson focus:ring-crimson h-4 w-4" {{ old('is_published', 1) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium text-navy">Publish immediately</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100 space-x-3">
                <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 text-xs font-heading font-bold uppercase tracking-wider text-gray-600 hover:text-navy border border-gray-300">Cancel</a>
                <button type="submit" class="bg-crimson hover:bg-red-700 text-white font-heading font-bold text-xs uppercase tracking-wider px-6 py-2.5 transition-colors">
                    Save FAQ
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
