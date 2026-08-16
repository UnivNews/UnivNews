<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin' || $user->role === 'editor') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Article $article): bool { return true; }
    public function create(User $user): bool { return true; }

    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }
}
