<?php

namespace App\Listeners;

use App\Artworks;
use App\Events\NewArtwork;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArtworkNotification;

class NewArtworkListener
{

    /**
     * @var string
     */
    public $queue = 'listeners';

    public $delay = 60;
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
     * @param  NewArtwork  $event
     * @return void
     */
    public function handle(NewArtwork $event)
    {
        $check = Artworks::whereId($event->artwork->id)->first();
        if($check)
        {
            $users = $event->artwork->user->followers()->where(['notification_on' => true])->get();
            Notification::send($users , new NewArtworkNotification($event->artwork));
        }
    }
}
