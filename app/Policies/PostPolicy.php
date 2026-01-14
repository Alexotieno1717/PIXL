<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $post->profile->is($user->profile);
    }
}
