<?php

namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;


    /**
     * Determine if user is allowed to view task's details
     *
     * @param \App\User $user
     * @param \App\Task $task
     * @return bool
     */
    public function show(User $user, Task $task)
    {
        if ($task->isOwnedBy($user))
        {
            return true;
        }

        if ($task->executors->intersect([$user])->count())
        {
            return true;
        }
        return false;
    }
}
