<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ── Core Stats ────────────────────────────────────────────────
        $totalArticles   = Article::count();
        $totalViews      = Article::sum('views_count');
        $pendingArticles = Article::where('status', Article::STATUS_PENDING_REVIEW)->count();
        $activeAuthors   = User::where('role', User::ROLE_AUTHOR)
                               ->where('author_status', User::STATUS_APPROVED)
                               ->count();

        // Month-over-month deltas
        $thisMonth   = Article::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $lastMonth   = Article::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $articleDelta = $lastMonth > 0 ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1) : null;

        // New authors this week
        $newAuthorsThisWeek = User::where('role', User::ROLE_AUTHOR)
                                  ->where('author_status', User::STATUS_APPROVED)
                                  ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                  ->count();

        $stats = [
            'total_articles'       => $totalArticles,
            'total_views'          => $totalViews,
            'pending_articles'     => $pendingArticles,
            'active_authors'       => $activeAuthors,
            'published_articles'   => Article::where('status', Article::STATUS_PUBLISHED)->count(),
            'drafts'               => Article::where('status', Article::STATUS_DRAFT)->count(),
            'article_delta'        => $articleDelta,
            'new_authors_week'     => $newAuthorsThisWeek,
        ];

        // ── Publishing Trend Chart (Last 12 Months) ───────────────────
        $trendData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->startOfMonth();
            $count = Article::where('status', Article::STATUS_PUBLISHED)
                            ->whereYear('published_at',  $month->year)
                            ->whereMonth('published_at', $month->month)
                            ->count();
            $trendData[] = [
                'label' => $month->format('M Y'),
                'short' => $month->format('M'),
                'count' => $count,
            ];
        }

        // ── Recent Articles ───────────────────────────────────────────
        $recentArticles = Article::with(['user.university', 'category'])
                                 ->latest()
                                 ->take(6)
                                 ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'trendData'));
    }
}
