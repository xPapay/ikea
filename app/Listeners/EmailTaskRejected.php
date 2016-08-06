<?php

namespace App\Listeners;

use App\Events\TaskWasRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailTaskRejected
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
     * @param  TaskWasRejected  $event
     * @return void
     */
    public function handle(TaskWasRejected $event)
    {
        //
    }
}
