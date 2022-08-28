<?php

namespace App\Listeners;

use App\Models\Wishlist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveOrderedItemsFromWishlist
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->order;
        if ($order->is_wishlist) {
            $orderItems = $order->items;
            Wishlist::where('cust_id', $order->user_id)
                ->get()->each(function($wish) use ($orderItems) {
                    if ( $orderItems->contains('product_id', $wish->prod_id) ) {
                        $wish->delete();
                    }
            });

        }
    }
}
