<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $totalArticles     = Article::where('user_id', $userId)->count();
        $publishedArticles = Article::where('user_id', $userId)->where('status', Article::STATUS_PUBLISHED)->count();
        $pendingReview     = Article::where('user_id', $userId)->where('status', Article::STATUS_PENDING_REVIEW)->count();
        $drafts            = Article::where('user_id', $userId)->where('status', Article::STATUS_DRAFT)->count();
        $rejected          = Article::where('user_id', $userId)->where('status', Article::STATUS_REJECTED)->count();
        $totalViews        = Article::where('user_id', $userId)->sum('views_count');

        // Month-over-month calculation for author
        $thisMonth = Article::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $lastMonth = Article::where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $articleDelta = $lastMonth > 0 ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1) : null;

        $stats = [
            'total_articles'     => $totalArticles,
            'published_articles' => $publishedArticles,
            'pending_review'     => $pendingReview,
            'drafts'             => $drafts,
            'rejected'           => $rejected,
            'total_views'        => $totalViews,
            'article_delta'      => $articleDelta,
        ];

        $recentArticles = Article::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('author.dashboard', compact('stats', 'recentArticles'));
    }
}
