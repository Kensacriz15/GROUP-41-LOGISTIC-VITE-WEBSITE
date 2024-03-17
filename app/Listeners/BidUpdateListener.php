<?php

namespace App\Listeners;

use App\Events\NewBidPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BidUpdateListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewBidPlaced  $event
     * @return void
     */
    public function handle(NewBidPlaced $event)
    {
        broadcast(new NewBidPlaced($event->bid))->toOthers();
    }
}
