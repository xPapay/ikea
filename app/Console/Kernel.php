<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use App\NotificationUser;
use App\Events\FoundDelayedNotification;

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
    }
}
