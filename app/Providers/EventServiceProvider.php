<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\OrderStatusChanged;
use App\Listeners\GivePointsWhenOrderDelivered;
use App\Listeners\PrepareCartTransfer;
use App\Listeners\ReduceOrderItemsStock;
use App\Listeners\RemoveOrderedItemsFromWishlist;
use App\Listeners\RestoreStockAndPoints;
use App\Listeners\SendOrderConfirmationMail;
use App\Listeners\SendOrderStatusChangeMail;
use App\Listeners\SendWelcomeMail;
use App\Listeners\TransferGuestCartToUser;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Login;
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
            SendOrderConfirmationMail::class,
            ReduceOrderItemsStock::class,
            RemoveOrderedItemsFromWishlist::class
        ],
        OrderStatusChanged::class => [
            SendOrderStatusChangeMail::class,
            GivePointsWhenOrderDelivered::class,
            RestoreStockAndPoints::class
        ],
        Attempting::class => [
            PrepareCartTransfer::class
        ],
        Login::class => [
            TransferGuestCartToUser::class
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
