<?php

namespace App\Listeners;

use App\Events\FoundTaskBeforeDeadline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailTaskBeforeDeadline extends NotificationListener
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
     * @param  FoundTaskBeforeDeadline  $event
     * @return void
     */
    public function handle(FoundTaskBeforeDeadline $event)
    {
        $users = $event->notification->involved_users;
        $notificationType = $event->notification->type;

        foreach ($users as $user)
        {
            if ($user->notify_task_before_deadline == 0) {
                continue;
            }

            if ($this->scheduleNotification($event, $user)) {
                continue;
            }

            Mail::send('email.task_created', ['headline' => $notificationType, 'notification' => $event->notification], function ($m) use ($user, $notificationType) {
            $m->to($user->email)->subject($notificationType);
            });

            \DB::table('notification_user')
                ->where('user_id', $user->id)
                ->where('notification_id', $event->notification->id)
                ->update(['delayed' => 0]);
        }
    }
}
