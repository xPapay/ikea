<?php

namespace App\Listeners;

use App\Events\TaskWasDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailTaskDeleted extends NotificationListener
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
        $users = $event->notification->involved_users->except($event->notification->user->id);

        foreach ($users as $user)
        {

            if ($user->notify_task_deleted == 0) {
                continue;
            }

            if ($this->scheduleNotification($event, $user)) {
                continue;
            }

            Mail::send('email.task_deleted', ['name' => $event->notification->task->name], function ($m) use ($user) {
                $m->to($user->email)->subject('Odstranenie ulohy');
            });
        }
    }
}
