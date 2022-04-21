<?php

namespace App\Listeners;

use App\User;
use App\Events\FollowEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\FollowedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowListener
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
     * @param  FollowEvent  $event
     * @return void
     */
    public function handle(FollowEvent $event)
    {
        $notifiable = User::whereId($event->userFollowed_id)->first();
        $check = DB::table('notifications')->where('data', 'like', '%'.'"id":'.$event->byUser->id.'%')
        ->where('notifiable_id',$notifiable->id)->where('type',FollowedNotification::class)->first();
        if($check)
        {
            return;
        }
        if($notifiable)
        {
            $notifiable->notify(new FollowedNotification($event->byUser));
        } 
    }
}
