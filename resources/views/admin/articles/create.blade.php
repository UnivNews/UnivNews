@extends('layouts.admin')

@section('title', 'Create Article - University News')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <a href="{{ route('admin.articles') }}" class="text-sm font-sans text-gray-500 hover:text-navy mb-2 inline-block">&larr; Back to Articles</a>
        <h2 class="text-3xl font-heading font-bold text-navy">Create New Article</h2>
    </div>
</div>

<form action="{{ route('admin.articles.store') }}" method="POST" class="bg-white shadow-sm border border-border-main p-8 max-w-4xl">
    @csrf

    <div class="space-y-6">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Title <span class="text-crimson">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy text-navy font-serif text-xl px-4 py-3" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Category & Status Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="category_id" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Category <span class="text-crimson">*</span></label>
                <select name="category_id" id="category_id" class="w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-2.5" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Status <span class="text-crimson">*</span></label>
                <select name="status" id="status" class="w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-2.5" required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Visible)</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Excerpt -->
        <div>
            <label for="excerpt" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Excerpt (Summary)</label>
            <textarea name="excerpt" id="excerpt" rows="3" class="w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-gray-700">{{ old('excerpt') }}</textarea>
            <p class="text-gray-400 text-xs mt-1">A brief summary that appears on listing pages. Leave blank to auto-generate.</p>
            @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Full Content <span class="text-crimson">*</span></label>
            <textarea name="content" id="content" rows="15" class="w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy font-serif px-4 py-3 text-gray-800" required>{{ old('content') }}</textarea>
            <p class="text-gray-400 text-xs mt-1">HTML is supported for formatting.</p>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Actions -->
        <div class="pt-6 border-t border-border-main flex items-center justify-end space-x-4">
            <a href="{{ route('admin.articles') }}" class="text-gray-500 hover:text-navy font-sans font-medium uppercase tracking-wider text-sm px-4 py-2">Cancel</a>
            <button type="submit" class="bg-navy hover:bg-black text-white px-8 py-3 font-heading font-bold text-sm uppercase tracking-wider transition-colors">
                Save Article
            </button>
        </div>
    </div>
</form>
@endsection
