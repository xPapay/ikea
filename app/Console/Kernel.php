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
            $tasksBeforeDeadline = Task::daysBeforeDeadline(5)->get();
            foreach($tasksBeforeDeadline as $task)
            {
                $notification = Notification::create(['type' => 'Úloha pred deadlajnom', 'user_id' => $task->orderer->id, 'task_id' => $task->id]);
                $executorsAndOrderer = $task->executorsList;
                array_push($executorsAndOrderer, $task->orderer->id);
                $notification->involved_users()->sync($executorsAndOrderer);
                event(new FoundTaskBeforeDeadline($notification));
            }
        })->dailyAt('11:37');
    }
}
