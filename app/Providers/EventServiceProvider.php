<?php

namespace App\Providers;

use App\Events\SendPushNotificationEvent;
use App\Events\UserPointsUpdatedEvent;
use App\Listeners\SendPushNotificationListener;
use App\Listeners\UpdateUserBadgeListener;
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
        UserPointsUpdatedEvent::class => [
            UpdateUserBadgeListener::class,
        ],
        SendPushNotificationEvent::class => [
            SendPushNotificationListener::class,
        ],
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
