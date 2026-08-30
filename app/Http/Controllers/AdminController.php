<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'total_views' => Article::sum('views_count'),
            'drafts' => Article::where('status', 'draft')->count(),
        ];

        $recentArticles = Article::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }

    public function articles()
    {
        $articles = Article::with(['user', 'category'])
            ->latest()
            ->paginate(15);

        return view('admin.articles.index', compact('articles'));
    }

    public function createArticle()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = Auth::guard('admin')->id();
        
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles')->with('success', 'Article created successfully.');
    }

    public function editArticle(Article $article)
    {
        Gate::authorize('update', $article);
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function updateArticle(Request $request, Article $article)
    {
        Gate::authorize('update', $article);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        if ($validated['title'] !== $article->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($validated['status'] === 'published' && !$article->published_at) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.articles')->with('success', 'Article updated successfully.');
    }

    public function deleteArticle(Article $article)
    {
        Gate::authorize('delete', $article);
        $article->delete();
        return redirect()->route('admin.articles')->with('success', 'Article deleted successfully.');
    }
}
