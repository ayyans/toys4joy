<?php

namespace App\Listeners;

use App\Mail\OrderStatusChangedMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusChangeMail
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
        $to = $order->user_id ? $order->user->email : $order->additional_details['email'];
        Mail::to($to)->send(new OrderStatusChangedMail($order));
    }
}
