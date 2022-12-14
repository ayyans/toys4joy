<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\OrderStatusChanged;
use App\Listeners\GivePointsWhenOrderDelivered;
use App\Listeners\SendOrderConfirmationMail;
use App\Listeners\SendOrderStatusChangeMail;
use App\Listeners\SendWelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendWelcomeMail::class
        ],
        OrderPlaced::class => [
            SendOrderConfirmationMail::class
        ],
        OrderStatusChanged::class => [
            SendOrderStatusChangeMail::class,
            GivePointsWhenOrderDelivered::class
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
