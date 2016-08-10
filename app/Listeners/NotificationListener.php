<?php

namespace App\Listeners;


abstract class NotificationListener
{
	protected function scheduleNotification($event, $user)
	{
		$now = \Carbon\Carbon::now();

            $currentTimeStamp = strtotime($now->hour . ":" . $now->minute, $now->timestamp); //17:00
            $noInterruptFromTimestamp = strtotime($user->no_interruption_from_time, $now->timestamp); //19:00
            $noInterruptToTimestamp = strtotime($user->no_interruption_to_time, $now->timestamp); // 02:00
            if (($currentTimeStamp <= $noInterruptToTimestamp) && ($currentTimeStamp > $noInterruptFromTimestamp)) {
                // save into DB for cron

                $notification = $user->notifications()->where('id', $event->notification->id)->first();
                $notification->pivot->delayed = true;
                $notification->pivot->save();
                return true;
            }
            return false;
	}
}