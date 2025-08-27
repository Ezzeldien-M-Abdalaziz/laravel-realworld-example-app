<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\User;
class ArticleRevisionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        return $user->id === $article->user_id || $user->is_admin;
    }

    public function revert(User $user, Article $article): bool
    {
        return $user->id === $article->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ArticleRevision $articleRevision): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArticleRevision $articleRevision): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ArticleRevision $articleRevision): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ArticleRevision $articleRevision): bool
    {
        return false;
    }
}
