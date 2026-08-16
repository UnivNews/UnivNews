<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $featuredArticle = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->first();

        $recentArticles = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $featuredArticle?->id)
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        $trendingResearch = Article::whereHas('category', function($q) {
                $q->where('slug', 'research-innovation');
            })
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('public.home', compact('featuredArticle', 'recentArticles', 'trendingResearch'));
    }

    public function research()
    {
        $category = Category::where('slug', 'research-innovation')->firstOrFail();
        
        $featuredResearch = Article::where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->first();

        $articles = Article::where('category_id', $category->id)
            ->where('id', '!=', $featuredResearch?->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $breakingNews = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('public.research', compact('category', 'featuredResearch', 'articles', 'breakingNews'));
    }

    public function category(Category $category)
    {
        $articles = $category->articles()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('public.category', compact('category', 'articles'));
    }

    public function article(Article $article)
    {
        if ($article->status !== 'published' || !$article->published_at || $article->published_at > now()) {
            abort(404);
        }

        // Increment view count
        $article->increment('views_count');

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->limit(3)
            ->get();

        return view('public.article', compact('article', 'relatedArticles'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $articles = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('public.search', compact('articles', 'query'));
    }
}
