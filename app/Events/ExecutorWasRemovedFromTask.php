<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Notification;


class ExecutorWasRemovedFromTask extends Event
{
    use SerializesModels;

    public $notification;
    public $removedUsers;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notification, $users)
    {
        $this->notification = $notification;
        $this->removedUsers = $users;
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
