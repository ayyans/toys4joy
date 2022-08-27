<?php

namespace App\Listeners;

use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RestoreStockAndPoints
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
        if ($order->order_status == 'cancelled') {
            // return stock
            foreach ($order->items as $item) {
                $item->product()->increment('qty', $item->quantity);
            }
            // return points
            if ($order->user_id && $order->previous_order_status == 'delivered') {
                $qarInPoints = Setting::where('name', 'qar_in_points')->value('value') ?? 2;
                $rewardPoints = round($order->total_amount * $qarInPoints);
                $orderNumber = $order->order_number;
                $order->user->withdraw($rewardPoints, ['description' => "Order #$orderNumber: Cancelled reward points"]);
            }
        }
    }
}
