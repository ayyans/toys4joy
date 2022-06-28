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
        $data = $event->user;
        Mail::to(auth()->user()->email)->send(new OrderConfirmationMail($data));
        Mail::to(User::first()->email)->send(new OrderReceivedMailToAdmin($data));
    }
}
