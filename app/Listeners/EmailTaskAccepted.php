<?php

namespace App\Listeners;

use App\Events\TaskWasAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailTaskAccepted
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
     * @param  TaskWasAccepted  $event
     * @return void
     */
    public function handle(TaskWasAccepted $event)
    {
        //
    }
}
