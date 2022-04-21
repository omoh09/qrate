<?php

namespace App\Providers;

use App\Providers\BidEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BidListener
{
    public $delay = 10;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BidEvent  $event
     * @return void
     */
    public function handle(BidEvent $event)
    {
        //
    }
}
