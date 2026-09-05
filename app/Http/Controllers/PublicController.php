<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        // 1. Fetch active boosted articles
        $activeBoosts = \App\Models\Boost::with('article')
            ->where('status', 'active')
            ->orderBy('start_date', 'desc')
            ->limit(5)
            ->get();

        $boostedArticles = $activeBoosts->map(fn($boost) => $boost->article);

        // 2. Fetch latest articles to fill the gap if boosted articles are less than 5
        $limit = 5 - $boostedArticles->count();
        $latestArticles = collect();
        if ($limit > 0) {
            $latestArticles = Article::where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->when($boostedArticles->isNotEmpty(), function ($q) use ($boostedArticles) {
                    $q->whereNotIn('id', $boostedArticles->pluck('id'));
                })
                ->orderBy('published_at', 'desc')
                ->limit($limit)
                ->get();
        }

        $featuredArticles = $boostedArticles->merge($latestArticles);
        $featuredArticle = $featuredArticles->first();

        // 3. Setup Marquee Text
        if ($boostedArticles->isNotEmpty()) {
            $marqueeArticles = $boostedArticles;
        } else {
            // Skenario 1: Belum ada yang boost, ambil artikel terbaru
            $marqueeArticles = $featuredArticles->take(1);
        }

        // 4. Fetch Recent Articles (exclude the one currently highlighted in first spot of slider)
        $recentArticles = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $featuredArticle?->id)
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        // 5. Fetch Trending Research
        $trendingResearch = Article::whereHas('category', function($q) {
                $q->where('slug', 'research-innovation');
            })
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('public.home', compact('featuredArticle', 'featuredArticles', 'recentArticles', 'trendingResearch', 'marqueeArticles'));
    }

    public function research()
    {
        $category = Category::firstOrCreate(['slug' => 'research-innovation'], ['name' => 'Research & Innovation']);
        
        $featuredResearchArticles = Article::where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $featuredResearch = $featuredResearchArticles->first();

        $articles = Article::where('category_id', $category->id)
            ->whereNotIn('id', $featuredResearchArticles->pluck('id'))
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

        return view('public.research', compact('category', 'featuredResearch', 'featuredResearchArticles', 'articles', 'breakingNews'));
    }

    public function achievements()
    {
        $category = Category::firstOrCreate(['slug' => 'achievements'], ['name' => 'Achievements']);

        $featuredAchievementArticles = Article::where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $articles = Article::where('category_id', $category->id)
            ->whereNotIn('id', $featuredAchievementArticles->pluck('id'))
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();

        return view('public.achievements', compact('category', 'featuredAchievementArticles', 'articles'));
    }

    public function events()
    {
        $category = Category::firstOrCreate(['slug' => 'events'], ['name' => 'Events']);

        $featuredEventArticles = Article::where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $articles = Article::where('category_id', $category->id)
            ->whereNotIn('id', $featuredEventArticles->pluck('id'))
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();

        return view('public.event', compact('category', 'featuredEventArticles', 'articles'));
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
        $canPreview = false;
        if (auth()->guard('admin')->check()) {
            $canPreview = true;
        } elseif (auth()->guard('web')->check() && auth()->guard('web')->user()->id === $article->user_id) {
            $canPreview = true;
        }

        $isPublished = $article->status === 'published' && $article->published_at && $article->published_at <= now();

        if (!$canPreview && !$isPublished) {
            abort(404);
        }

        // Increment view count only if actually published and viewed by public
        if ($isPublished && !$canPreview) {
            $article->increment('views_count');
        }

        $article->load(['user.university', 'boosts']);
        $isBoosted = $article->isBoosted();

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->limit(3)
            ->get();

        return view('public.article', compact('article', 'relatedArticles', 'isBoosted'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $articles = Article::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if (!empty($query)) {
            $terms = array_filter(explode(' ', $query));
            $articles->where(function($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function($subQ) use ($term) {
                        $subQ->where('title', 'ilike', "%{$term}%")
                             ->orWhere('excerpt', 'ilike', "%{$term}%")
                             ->orWhere('content', 'ilike', "%{$term}%")
                             ->orWhereHas('tags', fn($t) => $t->where('name', 'ilike', "%{$term}%"));
                    });
                }
            });
        }

        $articles = $articles->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('public.search', compact('articles', 'query'));
    }

    public function tag($name)
    {
        $tag = Tag::where('name', $name)->firstOrFail();

        $articles = $tag->articles()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return view('public.tag', compact('tag', 'articles'));
    }
}
