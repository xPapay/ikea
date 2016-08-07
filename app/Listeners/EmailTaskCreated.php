<?php

namespace App\Listeners;

use App\Events\TaskWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailTaskCreated
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
     * @param  TaskWasCreated  $event
     * @return void
     */
    public function handle(TaskWasCreated $event)
    {
        $users = $event->notification->involved_users()->select('email')->get()->toArray();
        foreach ($users as $user)
        {
            Mail::send('email.task_created', ['headline' => 'Bola vytvorená nová úloha, na ktorú ste boli priradený', 'notification' => $event->notification], function ($m) use ($user) {
                $m->to($user['email'])->subject('Pridelenie ulohy');
            });
        }
    }
}
