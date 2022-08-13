<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GivePointsWhenOrderDelivered
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
        if ($order->order_status == 'delivered') {
            $rewardPoints = round($order->total_amount / 50);
            $orderID = $order->order_number;
            $order->user->deposit($rewardPoints, ['description' => "Order #$orderID: Purchase reward points"]);
        }
    }
}
