<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with(['user.university', 'category', 'tags'])->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($category = $request->input('category')) {
            $query->where('category_id', $category);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $articles = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'                  => 'required|string|max:255',
            'excerpt'                => 'nullable|string|max:1000',
            'content'                => 'required|string',
            'category_id'            => 'required|exists:categories,id',
            'status'                 => 'required|in:draft,published,pending_review',
            'featured_image'         => 'nullable|image|max:4096',
            'tags'                   => 'nullable|array',
            'event_type'             => 'nullable|string|max:100',
            'event_date'             => 'nullable|date',
            'registration_link'      => 'nullable|url|max:2048',
            'registration_deadline'  => 'nullable|date',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $article = new Article();
        $article->title = $validated['title'];
        $article->slug = $slug;
        $article->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        $article->content = $validated['content'];
        $article->category_id = $validated['category_id'];
        $article->user_id = auth()->id();
        $article->status = $validated['status'];

        if ($validated['status'] === Article::STATUS_PUBLISHED) {
            $article->published_at = now();
        }

        // Event fields
        $eventCategory = Category::find($validated['category_id']);
        if ($eventCategory && strtolower($eventCategory->slug) === 'events') {
            $article->event_type            = $validated['event_type'] ?? null;
            $article->event_date            = $validated['event_date'] ?? null;
            $article->registration_link     = $validated['registration_link'] ?? null;
            $article->registration_deadline = $validated['registration_deadline'] ?? null;
        } else {
            $article->event_type            = null;
            $article->event_date            = null;
            $article->registration_link     = null;
            $article->registration_deadline = null;
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image_path = 'storage/' . $path;
        }

        $article->save();

        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $trimmed = trim(str_replace('#', '', $tagName));
                if ($trimmed) {
                    $tag = Tag::firstOrCreate(['name' => $trimmed]);
                    $tagIds[] = $tag->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title'                  => 'required|string|max:255',
            'excerpt'                => 'nullable|string|max:1000',
            'content'                => 'required|string',
            'category_id'            => 'required|exists:categories,id',
            'status'                 => 'required|in:draft,published,pending_review',
            'featured_image'         => 'nullable|image|max:4096',
            'tags'                   => 'nullable|array',
            'event_type'             => 'nullable|string|max:100',
            'event_date'             => 'nullable|date',
            'registration_link'      => 'nullable|url|max:2048',
            'registration_deadline'  => 'nullable|date',
        ]);

        if ($validated['title'] !== $article->title) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $article->slug = $slug;
        }

        $article->title = $validated['title'];
        $article->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        $article->content = $validated['content'];
        $article->category_id = $validated['category_id'];
        $article->status = $validated['status'];

        if ($validated['status'] === Article::STATUS_PUBLISHED && !$article->published_at) {
            $article->published_at = now();
        }

        // Event fields
        $eventCategory = Category::find($validated['category_id']);
        if ($eventCategory && strtolower($eventCategory->slug) === 'events') {
            $article->event_type            = $validated['event_type'] ?? null;
            $article->event_date            = $validated['event_date'] ?? null;
            $article->registration_link     = $validated['registration_link'] ?? null;
            $article->registration_deadline = $validated['registration_deadline'] ?? null;
        } else {
            $article->event_type            = null;
            $article->event_date            = null;
            $article->registration_link     = null;
            $article->registration_deadline = null;
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image_path = 'storage/' . $path;
        }

        $article->save();

        if (isset($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $trimmed = trim(str_replace('#', '', $tagName));
                if ($trimmed) {
                    $tag = Tag::firstOrCreate(['name' => $trimmed]);
                    $tagIds[] = $tag->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
