<?php

namespace App\Providers;

use App\Events\MeetingCreated;
use App\Events\MeetingDeleted;
use App\Events\MeetingUpdated;
use App\Listeners\PersistCreatedMeeting;
use App\Listeners\PersistUpdatedMeeting;
use App\Listeners\RemoveDeletedMeetingFromDB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MeetingCreated::class => [
            PersistCreatedMeeting::class,
        ],
        MeetingUpdated::class => [
            PersistUpdatedMeeting::class,
        ],
        MeetingDeleted::class => [
            RemoveDeletedMeetingFromDB::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
