<?php

namespace App\Listeners;

use App\Events\TaskWasDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailTaskDeleted
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
     * @param  TaskWasDeleted  $event
     * @return void
     */
    public function handle(TaskWasDeleted $event)
    {
        foreach ($event->executors as $user)
        {
            Mail::send('email.task_deleted', ['name' => $event->name], function ($m) use ($user) {
                $m->to($user->email)->subject('Odstranenie ulohy');
            });
        }
    }
}
