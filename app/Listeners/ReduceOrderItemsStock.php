<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReduceOrderItemsStock
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $items = $event->order->items;
        foreach ($items as $item) {
            $item->product()->decrement('qty', $item->quantity);
        }
    }
}
