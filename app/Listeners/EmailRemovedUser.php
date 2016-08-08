<?php

namespace App\Listeners;

use App\Events\ExecutorWasRemovedFromTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;


class EmailRemovedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExecutorWasRemovedFromTask  $event
     * @return void
     */
    public function handle(ExecutorWasRemovedFromTask $event)
    {
        foreach ($event->removedUsers as $user)
        {

            if ($user->notify_task_unassigned == 0) {
                continue;
            }

            Mail::send('email.user_removed_from_task', ['headline' => 'Boli ste odstránený z úlohy:', 'notification' => $event->notification], function ($m) use ($user) {
                $m->to($user->email)->subject('Odobratie ulohy');
            });
        }
    }
}
