<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function show(Article $article): View
    {
        $article->load(['user.university', 'category', 'tags']);
        return view('admin.articles.review', compact('article'));
    }

    public function approve(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'publish_date' => 'nullable|date',
            'publish_time' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        $publishDate = $validated['publish_date'] ?? date('Y-m-d');
        $publishTime = $validated['publish_time'] ?? date('H:i:s');

        try {
            $publishedAt = Carbon::parse("{$publishDate} {$publishTime}");
        } catch (\Exception $e) {
            $publishedAt = now();
        }

        $article->update([
            'status' => Article::STATUS_PUBLISHED,
            'published_at' => $publishedAt,
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.articles.index')->with('success', "Article '{$article->title}' approved and published successfully.");
    }

    public function reject(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:2000',
        ]);

        $article->update([
            'status' => Article::STATUS_REJECTED,
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->route('admin.articles.index')->with('success', "Article '{$article->title}' rejected with revision notes.");
    }
}
