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
        $data = $event->data;
        if ($data['status'] === 'Delivered') {
            $rewardPoints = round($data['total'] / 50);
            $orderID = $data['order_number'];
            $data['customer']->deposit($rewardPoints, ['description' => "Order #$orderID: Purchase reward points"]);
        }
    }
}
