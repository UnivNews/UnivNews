<?php

namespace App\Http\Controllers;

use App\Models\Boost;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function featured()
    {
        $today = now()->toDateString();

        $boosts = Boost::with(['article.user', 'article.category', 'article.tags'])
            ->where('status', 'active')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereHas('article', function ($q) {
                $q->where('status', Article::STATUS_PUBLISHED)
                  ->whereNotNull('published_at')
                  ->where('published_at', '<=', now());
            })
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();
            
        $articles = $boosts->map(fn($boost) => $boost->article)->filter()->unique('id')->values();

        return response()->json([
            'data' => $articles
        ]);
    }
}
