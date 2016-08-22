<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Comment;
use App\User;

class CommentPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Comment $comment)
    {
        if ($user->isAdmin())
        {
            return true;
        }

        return false;
    }
}
