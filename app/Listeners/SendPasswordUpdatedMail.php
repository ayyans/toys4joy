<?php

namespace App\Listeners;

use App\Mail\PasswordUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordUpdatedMail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        Mail::to($user->email)->send(new PasswordUpdatedMail);
    }
}