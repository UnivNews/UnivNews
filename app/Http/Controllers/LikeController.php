<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Toggle like/unlike for the authenticated user on a given article.
     * Returns JSON: { liked: bool, count: int }
     */
    public function toggle(Request $request, Article $article): JsonResponse
    {
        // Only allow liking published articles
        if (! $article->isPublished()) {
            abort(403, 'You can only like published articles.');
        }

        $user = $request->user();

        $existing = ArticleLike::where('article_id', $article->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            ArticleLike::create([
                'article_id' => $article->id,
                'user_id'    => $user->id,
            ]);
            $liked = true;
        }

        $count = ArticleLike::where('article_id', $article->id)->count();

        return response()->json([
            'liked' => $liked,
            'count' => $count,
        ]);
    }
}
