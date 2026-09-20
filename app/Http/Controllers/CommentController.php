<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a new comment on the given article.
     */
    public function store(Request $request, Article $article): JsonResponse
    {
        // Only allow commenting on published articles
        if (! $article->isPublished()) {
            abort(403, 'You can only comment on published articles.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        $comment = ArticleComment::create([
            'article_id' => $article->id,
            'user_id'    => $request->user()->id,
            'body'       => $validated['body'],
        ]);

        $comment->load('user');

        return response()->json([
            'comment' => [
                'id'         => $comment->id,
                'body'       => $comment->body,
                'created_at' => $comment->created_at->diffForHumans(),
                'user'       => [
                    'id'          => $comment->user->id,
                    'name'        => $comment->user->name,
                    'avatar_path' => $comment->user->avatar_path,
                ],
            ],
        ], 201);
    }

    /**
     * Soft-hide (delete) a comment. Only the comment author or an admin may do this.
     */
    public function destroy(Request $request, ArticleComment $comment): JsonResponse
    {
        $user = $request->user();

        // Authorize: own comment or admin
        if ($comment->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'You are not authorized to delete this comment.');
        }

        $comment->update(['is_hidden' => true]);

        return response()->json(['deleted' => true]);
    }
}
