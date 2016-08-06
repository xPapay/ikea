<?php

namespace App\Listeners;

use App\Events\ExecutorWasAddedToTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailAddedUser
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
     * @param  ExecutorWasAddedToTask  $event
     * @return void
     */
    public function handle(ExecutorWasAddedToTask $event)
    {
        foreach ($event->addedUsers as $user)
        {
            Mail::send('email.task_created', ['headline' => 'Boli ste priradený na úlohu', 'notification' => $event->notification], function ($m) use ($user) {
                $m->to($user->email)->subject('Pridelenie ulohy');
            });
        }
    }
}
