<?php

namespace App\Policies;

use App\Executable;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy extends TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Executable $executable)
    {
        if ($executable->isOwnedBy($user) || $user->isAdmin())
        {
            return true;
        }

        if ($executable->executors->intersect([$user])->count() || $executable->followupBy == $user)
        {
            return true;
        }
        return false;
    }
}
