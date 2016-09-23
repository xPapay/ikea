<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use App\NotificationUser;
use App\Notification;
use App\Events\FoundDelayedNotification;
use App\Events\FoundTaskBeforeDeadline;
use App\Task;
use App\Task_User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $delayedNotifications = NotificationUser::where('delayed', true)->get();
            foreach($delayedNotifications as $delayedNotification)
            {
                event(new FoundDelayedNotification($delayedNotification));
            }
        })->everyMinute();

        $schedule->call(function () {
            $today = \Carbon\Carbon::now();
            $date = $today->addWeekDays(5);
            $tasksBeforeDeadline = Task_User::whereHas('task', function ($query) use ($date) {
                $query->where('deadline', '<=', $date->toDateString())->where('deadline', '>=', $today->toDateString());
            })->with(['task.orderer', 'user'])->unfinished(200)->get();
            foreach($tasksBeforeDeadline as $task_user)
            {
                $notification = Notification::create(['type' => 'Úloha pred deadlajnom', 'user_id' => $task_user->task->orderer->id, 'task_id' => $task_user->task_id]);
                $notification->involved_users()->sync([$task_user->user_id, $task_user->task->orderer->id]);
                event(new FoundTaskBeforeDeadline($notification));
            }
        })->dailyAt('09:00');
    }
}
