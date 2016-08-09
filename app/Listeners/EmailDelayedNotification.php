<?php

namespace App\Listeners;

use App\Events\FoundDelayedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailDelayedNotification extends NotificationListener
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
     * @param  FoundDelayedNotification  $event
     * @return void
     */
    public function handle(FoundDelayedNotification $event)
    {
        $user = $event->delayedNotification->user;
        $notificationType = $event->delayedNotification->notification->type;

        if (($user->notify_task_assigned == 0) && (($notificationType == 'Úloha vytvorená') || ($notificationType == 'Priradenie na úlohu'))) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_task_unassigned == 0) && (($notificationType == 'Úloha zmazaná') || ($notificationType == 'Odstránenie z úlohy'))) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_task_edited == 0) && ($notificationType == 'Úloha editovaná')) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_task_deleted == 0) && ($notificationType == 'Úloha zmazaná')) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_task_accomplished == 0) && ($notificationType == 'Úloha dokončená')) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_task_accepted == 0) && ($notificationType == 'Úloha akceptovaná')) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_task_rejected == 0) && ($notificationType == 'Úloha navrátená')) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if (($user->notify_comment_added == 0) && ($notificationType == 'Pridaný komentár')) {
            $event->delayedNotification->delayed = false;
            $event->delayedNotification->save();
            return;
        }

        if ($this->scheduleNotification($event->delayedNotification, $user)) {
            return;
        }


        Mail::send('email.task_created', ['headline' => $notificationType, 'notification' => $event->delayedNotification->notification], function ($m) use ($user, $notificationType) {
        $m->to($user->email)->subject($notificationType);
        });

        $event->delayedNotification->delayed = false;
        $event->delayedNotification->save();
        dd($event->delayedNotification);        
        
    }
}
