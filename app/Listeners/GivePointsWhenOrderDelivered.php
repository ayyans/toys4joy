<?php

namespace App\Listeners;

use App\Models\Setting;
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
            $qarInPoints = Setting::where('name', 'qar_in_points')->value('value') ?? 2;
            $rewardPoints = round($order->total_amount * $qarInPoints);
            $orderNumber = $order->order_number;
            $order->user->deposit($rewardPoints, ['description' => "Order #$orderNumber: Purchase reward points"]);
        }
    }
}
