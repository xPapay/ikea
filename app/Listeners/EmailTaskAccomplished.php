<?php

namespace App\Listeners;

use App\Events\TaskWasAccomplished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailTaskAccomplished
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
     * @param  TaskWasAccomplished  $event
     * @return void
     */
    public function handle(TaskWasAccomplished $event)
    {
        //
    }
}
