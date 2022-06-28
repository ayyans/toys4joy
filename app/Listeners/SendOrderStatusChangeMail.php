<?php

namespace App\Listeners;

use App\Mail\OrderStatusChangedMail;
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
        $data = $event->data;
        Mail::to(auth()->user()->email)->send(new OrderStatusChangedMail($data));
    }
}
