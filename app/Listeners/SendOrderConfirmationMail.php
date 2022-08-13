<?php

namespace App\Listeners;

use App\Mail\OrderConfirmationMail;
use App\Mail\OrderReceivedMailToAdmin;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationMail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->order->load('items.product', 'user', 'address', 'giftcards', 'coupon');
        $to = $order->user_id ? $order->user->email : $order->additional_details['email'];
        Mail::to($to)->send(new OrderConfirmationMail($order));
        Mail::to('toysforjoyorders@gmail.com')->send(new OrderReceivedMailToAdmin($order));
    }
}
