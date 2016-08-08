<?php

namespace App\Listeners;

use App\Events\TaskWasEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailTaskEdited extends NotificationListener
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
     * @param  TaskWasEdited  $event
     * @return void
     */
    public function handle(TaskWasEdited $event)
    {
        $users = $event->notification->involved_users->except($event->notification->user->id);
        foreach ($users as $user)
        {

            if ($user->notify_task_edited == 0) {
                continue;
            }

            if ($this->scheduleNotification($event, $user)) {
                continue;
            }

            Mail::send('email.task_created', ['headline' => 'Bola editova úloha, na ktorú ste priradený', 'notification' => $event->notification], function ($m) use ($user) {
                $m->to($user->email)->subject('Editacia ulohy');
            });
        }
    }
}
