<?php

namespace App\Listeners;

use App\Catalogue;
use App\Events\UserVerified;
use App\Notifications\WelcomeNotification;
use App\Profile;
use App\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserVerifiedListener
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
     * @param  UserVerified  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        //create artist profile if registered as an artist
        $user = $event->user;
        //TODO subscription for not only artist art supplier and art gallery

        if($user->role == 2 || $user->role == 3 ) {
            //Todo Add this subscription back
//            Subscription::create(
//                [
//                    'user_id' => $user->id,
//                    'plan_id' => 1,
//                    'starting_date' => Now()->format('Y-m-d'),
//                    'expiration_date' => Now()->addMonth()->format('Y-m-d'),
//                ]
//            );
        }
        Profile::create(
            [
                'user_id' => $user->id,
                'username' => $user->name,
            ]
        );
        Catalogue::create(
            [
                'user_id' => $user->id
            ]);

        if($user->role == 3)
        {
            $user->photos()->create();
        }
        $event->user->notify(new WelcomeNotification());
    }
}
