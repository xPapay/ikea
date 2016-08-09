<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\TaskWasCreated' => [
            'App\Listeners\EmailTaskCreated',
        ],
        'App\Events\TaskWasDeleted' => [
            'App\Listeners\EmailTaskDeleted',
        ],
        'App\Events\TaskWasAssigned' => [
            'App\Listeners\EmailTaskAssignment',
        ],
        'App\Events\TaskWasEdited' => [
            'App\Listeners\EmailTaskEdited',
        ],
        'App\Events\TaskWasAccomplished' => [
            'App\Listeners\EmailTaskAccomplished',
        ],
        'App\Events\TaskWasAccepted' => [
            'App\Listeners\EmailTaskAccepted',
        ],
        'App\Events\TaskWasRejected' => [
            'App\Listeners\EmailTaskRejected',
        ],
        'App\Events\CommentAdded' => [
            'App\Listeners\EmailCommentAdded',
        ],
        'App\Events\ExecutorWasRemovedFromTask' => [
            'App\Listeners\EmailRemovedUser',
        ],
        'App\Events\ExecutorWasAddedToTask' => [
            'App\Listeners\EmailAddedUser',
        ],
        'App\Events\FoundDelayedNotification' => [
            'App\Listeners\EmailDelayedNotification',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
