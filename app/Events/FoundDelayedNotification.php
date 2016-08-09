<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\NotificationUser;

class FoundDelayedNotification extends Event
{
    use SerializesModels;

    public $delayedNotification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NotificationUser $delayedNotification)
    {
        $this->delayedNotification = $delayedNotification;
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
