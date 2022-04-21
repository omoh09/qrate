<?php

namespace App\Listeners;

use App\Events\NewUser;
use App\Notifications\NewPostNotification;
use App\Notifications\WelcomeNotification;
use App\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewUserListener implements ShouldQueue
{

    public $queue = 'user-listeners';

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

    public function shouldQueue(NewUser $event)
    {
        return true;
    }

    /**
     * Handle the event.
     *
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUser $event)
    {
        $event->user->sendEmailVerificationNotification();
    }
}
