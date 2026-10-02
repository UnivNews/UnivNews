<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        $today = now()->toDateString();

        // 1. Proactively expire active boosts whose end_date has passed,
        // and activate scheduled boosts whose start_date has arrived.
        \App\Models\Boost::where('status', 'active')
            ->where('end_date', '<', $today)
            ->update(['status' => 'expired']);

        \App\Models\Boost::where('status', 'scheduled')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->update(['status' => 'active']);

        // 2. Fetch active boosted articles (max 5)
        $activeBoosts = \App\Models\Boost::with(['article.category', 'article.tags', 'article.user'])
            ->where('status', 'active')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereHas('article', function ($q) {
                $q->where('status', Article::STATUS_PUBLISHED)
                  ->whereNotNull('published_at')
                  ->where('published_at', '<=', now());
            })
            ->orderBy('start_date', 'desc')
            ->limit(5)
            ->get();

        $boostedArticles = $activeBoosts
            ->map(fn($boost) => $boost->article)
            ->filter()
            ->unique('id')
            ->values();

        // 3. Jika ada boost aktif → hero hanya tampilkan artikel yang di-boost.
        //    Jika tidak ada boost sama sekali → fallback ke 5 artikel terbaru.
        if ($boostedArticles->isNotEmpty()) {
            $featuredArticles = $boostedArticles;
        } else {
            $featuredArticles = Article::with(['category', 'tags', 'user'])
                ->where('status', Article::STATUS_PUBLISHED)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        }
        $featuredArticle = $featuredArticles->first();

        // 4. Setup Marquee Text
        if ($boostedArticles->isNotEmpty()) {
            $marqueeArticles = $boostedArticles;
        } else {
            $marqueeArticles = $featuredArticles->take(1);
        }

        // 5. Recent News — 6 artikel terbaru (exclude semua artikel di hero banner)
        $featuredIds = $featuredArticles->pluck('id')->filter()->unique();

        $recentArticles = Article::with(['category', 'tags', 'user'])
            ->where('status', Article::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotIn('id', $featuredIds)
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // 6. Others — artikel ke-7 dst (exclude semua artikel di hero + recent 6), paginated
        $excludeIds = $recentArticles->pluck('id')
            ->concat($featuredIds)
            ->unique()
            ->values();

        $perPage = in_array((int) request('perPage'), [10, 20, 30]) ? (int) request('perPage') : 10;

        $otherArticles = Article::with(['category', 'tags', 'user'])
            ->where('status', Article::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotIn('id', $excludeIds)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, ['*'], 'page')
            ->withQueryString();

        // 7. Trending — top 5 dari semua kategori berdasarkan views_count
        $trendingArticles = Article::with(['category', 'tags', 'user'])
            ->where('status', Article::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('public.home', compact(
            'featuredArticle', 'featuredArticles', 'marqueeArticles',
            'recentArticles', 'otherArticles', 'trendingArticles', 'perPage'
        ));
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

        // Eager load relations including engagement data
        $article->load(['user.university', 'boosts', 'likes', 'comments.user']);
        $isBoosted = $article->isBoosted();

        // Engagement data for the view
        $authUser     = auth()->guard('web')->user();
        $userHasLiked = $article->isLikedBy($authUser);
        $likeCount    = $article->likes->count();

        // Record reading history for authenticated readers
        if ($authUser && $isPublished && !$canPreview) {
            $history = \App\Models\ReadingHistory::firstOrNew([
                'user_id'    => $authUser->id,
                'article_id' => $article->id,
            ]);
            $history->last_read_at = now();
            $history->read_count = ($history->read_count ?? 0) + 1;
            $history->save();
        }

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->limit(3)
            ->get();

        return view('public.article', compact(
            'article',
            'relatedArticles',
            'isBoosted',
            'userHasLiked',
            'likeCount',
        ));
    }

    public function search(Request $request)
    {
        $query = trim((string)$request->input('q'));
        $sort = $request->input('sort', 'relevance');
        if (!in_array($sort, ['relevance', 'latest'])) {
            $sort = 'relevance';
        }
        $selectedCategory = $request->input('category', 'all');

        $driver = DB::connection()->getDriverName();

        $articles = Article::with(['category', 'tags', 'user'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if (!empty($query)) {
            if ($driver === 'pgsql') {
                $safeRegex = trim(preg_replace('/[^\p{L}\p{N}\s]/u', '', $query));
                if (empty($safeRegex)) {
                    $safeRegex = 'a^';
                }

                $vectorSql = "
                    setweight(to_tsvector('english', coalesce(articles.title, '')), 'A') ||
                    setweight(to_tsvector('english', coalesce(articles.excerpt, '')), 'B') ||
                    setweight(to_tsvector('english', regexp_replace(coalesce(articles.content, ''), '<[^>]+>', ' ', 'g')), 'D')
                ";

                $articles->select('articles.*')
                    ->selectRaw("
                        (
                            ts_rank(({$vectorSql}), websearch_to_tsquery('english', ?)) * 10
                            + CASE WHEN LOWER(articles.title) = LOWER(?) THEN 100 ELSE 0 END
                            + CASE WHEN articles.title ILIKE (? || '%') THEN 50 ELSE 0 END
                            + CASE WHEN articles.title ~* ('\\\\y' || ? || '\\\\y') THEN 40 ELSE 0 END
                            + CASE WHEN length(?) >= 4 AND articles.title ILIKE ('%' || ? || '%') THEN 25 ELSE 0 END
                            + CASE WHEN length(?) >= 4 AND articles.excerpt ILIKE ('%' || ? || '%') THEN 10 ELSE 0 END
                            + CASE WHEN EXISTS (
                                SELECT 1 FROM article_tag 
                                JOIN tags ON tags.id = article_tag.tag_id 
                                WHERE article_tag.article_id = articles.id AND tags.name ~* ('\\\\y' || ? || '\\\\y')
                            ) THEN 30 ELSE 0 END
                        ) as relevance_score
                    ", [$query, $query, $query, $safeRegex, $query, $query, $query, $query, $safeRegex])
                    ->selectRaw("
                        ts_headline('english', regexp_replace(articles.content, '<[^>]+>', ' ', 'g'),
                                    websearch_to_tsquery('english', ?),
                                    'StartSel=<mark>, StopSel=</mark>, MaxWords=35, MinWords=15') as search_snippet
                    ", [$query])
                    ->where(function($subQ) use ($vectorSql, $query, $safeRegex) {
                        $subQ->whereRaw("({$vectorSql}) @@ websearch_to_tsquery('english', ?)", [$query])
                             ->orWhere('articles.title', '~*', "\\y{$safeRegex}")
                             ->orWhereHas('tags', fn($t) => $t->where('name', '~*', "\\y{$safeRegex}\\y"))
                             ->orWhereHas('category', fn($c) => $c->where('name', '~*', "\\y{$safeRegex}\\y"));
                    });
            } else {
                // DB-agnostic fallback (MySQL / SQLite)
                $articles->select('articles.*')
                    ->selectRaw("
                        (
                            CASE WHEN LOWER(articles.title) = LOWER(?) THEN 100 ELSE 0 END
                            + CASE WHEN articles.title LIKE ? THEN 50 ELSE 0 END
                            + CASE WHEN articles.title LIKE ? THEN 25 ELSE 0 END
                            + CASE WHEN articles.excerpt LIKE ? THEN 10 ELSE 0 END
                            + CASE WHEN articles.content LIKE ? THEN 5 ELSE 0 END
                        ) as relevance_score
                    ", [
                        $query,
                        $query . '%',
                        '%' . $query . '%',
                        '%' . $query . '%',
                        '%' . $query . '%',
                    ])
                    ->where(function($subQ) use ($query) {
                        $subQ->where('articles.title', 'like', "%{$query}%")
                             ->orWhere('articles.excerpt', 'like', "%{$query}%")
                             ->orWhere('articles.content', 'like', "%{$query}%")
                             ->orWhereHas('tags', fn($t) => $t->where('name', 'like', "%{$query}%"))
                             ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$query}%"));
                    });
            }
        }

        // Category filter
        if (!empty($selectedCategory) && $selectedCategory !== 'all') {
            $articles->whereHas('category', fn($c) => $c->where('slug', $selectedCategory));
        }

        // Sorting
        if ($sort === 'latest') {
            $articles->orderByDesc('published_at');
        } else {
            if (!empty($query)) {
                $articles->orderByDesc('relevance_score')->orderByDesc('published_at');
            } else {
                $articles->orderByDesc('published_at');
            }
        }

        $articles = $articles->paginate(10)->withQueryString();

        // Categories for filter pills with published count
        $categories = Category::withCount(['articles' => fn($q) => $q->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())])
            ->orderBy('name')
            ->get();

        return view('public.search', compact('articles', 'query', 'sort', 'selectedCategory', 'categories'));
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
