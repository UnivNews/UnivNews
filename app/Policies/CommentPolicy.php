<?php

namespace App\Policies;

use App\Models\ArticleComment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can delete the given comment.
     * Allowed: comment author or admin.
     */
    public function delete(User $user, ArticleComment $comment): bool
    {
        return $comment->user_id === $user->id || $user->isAdmin();
    }
}
