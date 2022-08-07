<?php

namespace App\Listeners;

use App\Models\CartStorage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransferGuestCartToUser
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $userCart = cart();
        $userCartItems = $userCart->getContent()->toArray();

        $guestCart = session('guest_cart.data');
        $guestCartItems = $guestCart->toArray();

        $userCartItems = array_merge($userCartItems, $guestCartItems);
        $userCart->add($userCartItems);

        $dbCart = CartStorage::find(session('guest_cart.session') . '_cart_items');

        if ($dbCart) $dbCart->delete();
    }
}
