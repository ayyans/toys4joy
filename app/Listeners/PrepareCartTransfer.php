<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PrepareCartTransfer
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (auth()->guest()) {
            session()->flash('guest_cart', [
                'session' => session()->getId(),
                'data' => cart()->getContent()
            ]);
        }
    }
}
