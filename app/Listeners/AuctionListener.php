<?php

namespace App\Listeners;

use App\Admin;
use App\Auction;
use App\Events\NewAuction;
use App\Notifications\NewAuction as NewAuctionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuctionListener
{
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
     * @param  NewAuction  $event
     * @return void
     */
    public function handle(NewAuction $event)
    {
        $artwork = $event->artwork;
//        TODO add logic to notify all admin
        $admin = Admin::first();
        if($admin){
            $admin->notify(new NewAuctionNotification($artwork));
        }
    }
}
