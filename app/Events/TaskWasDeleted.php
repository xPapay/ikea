<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskWasDeleted extends Event
{
    use SerializesModels;

    public $name;
    public $executors;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $executors)
    {
        $this->name = $name;
        $this->executors = $executors;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
