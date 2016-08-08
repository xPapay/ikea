<?php

namespace App\Listeners;

use App\Events\CommentAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailCommentAdded extends NotificationListener
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
     * @param  CommentAdded  $event
     * @return void
     */
    public function handle(CommentAdded $event)
    {
        $users = $event->notification->involved_users->except($event->notification->user->id);
        foreach ($users as $user)
        {

            if ($user->notify_comment_added == 0) {
                continue;
            }

            if ($this->scheduleNotification($event, $user)) {
                continue;
            }

            Mail::send('email.comment_added', ['headline' => 'Bol pridaný komentár k úlohe, na ktorú ste priradený', 'notification' => $event->notification], function ($m) use ($user) {
                $m->to($user->email)->subject('Novy komentar');
            });
        }
    }
}
