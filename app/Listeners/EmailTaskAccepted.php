<?php

namespace App\Listeners;

use App\Events\TaskWasAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailTaskAccepted
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
     * @param  TaskWasAccepted  $event
     * @return void
     */
    public function handle(TaskWasAccepted $event)
    {
        $users = $event->notification->involved_users->except($event->notification->user->id);
        foreach ($users as $user)
        {
            Mail::send('email.task_created', ['headline' => 'Úloha bola akceptovaná ako splnená', 'notification' => $event->notification], function ($m) use ($user) {
                $m->to($user->email)->subject('Uloha akceptovana');
            });
        }
    }
}