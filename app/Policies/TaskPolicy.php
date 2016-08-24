<?php

namespace App\Policies;

use App\Executable;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;



    /**
     * Determine if user is allowed to view task's details
     *
     * @param \App\User $user
     * @param \App\Task $executable
     * @return bool
     */
    public function show(User $user, Executable $executable)
    {
        if ($executable->isOwnedBy($user) || $user->isAdmin())
        {
            return true;
        }

        if ($executable->executors->intersect([$user])->count())
        {
            return true;
        }

        if ($executable->supporters->intersect([$user])->count())
        {
            return true;
        }

        return false;
    }

    public function edit(User $user, Executable $executable)
    {
        if ($executable->isOwnedBy($user) || $user->isAdmin())
        {
            return true;
        }

        return false;
    }

    public function accomplish(User $user, Executable $executable)
    {
        // if ($user->isAdmin())
        // {
        //     return true;
        // }

        if ($executable->executors->intersect([$user])->count())
        {
            return true;
        }
        return false;
    }

    public function determine(User $user, Executable $executable)
    {
        if ($user->isAdmin())
        {
            return true;
        }
        
        if ($executable->isOwnedBy($user))
        {
            return true;
        }
        return false;
    }
}
