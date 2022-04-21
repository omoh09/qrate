<?php

namespace App\Listeners;

use App\Artworks;
use App\Events\LikeEvent;
use App\Exhibition;
use App\Likes;
use App\Notifications\ArtworkLikedNotification;
use App\Notifications\PostLikedNotification;
use App\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use function GuzzleHttp\Psr7\modify_request;

class LikeListener implements ShouldQueue
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
     * @param  LikeEvent  $event
     * @return void
     */
    public function handle(LikeEvent $event)
    {
        if($event->model->owner->user_id == $event->model->user->id || (bool) $event->model->owner->user->notification_on == false)
        {
            return;
        }
        if($event->model->owner instanceof Post)
        {
            $check = Likes::whereId($event->model->id)->first();
            if($check)
            {
                $event->model->owner->user->notify(new PostLikedNotification($check));
                return;
            }
        }

        if($event->model->owner instanceof Artworks)
        {
            $check = Likes::whereId($event->model->id)->first();
            if($check)
            {
                $event->model->owner->user->notify(new ArtworkLikedNotification($check));
                return;
            }
        }
        //TODO include exhibition notification if needed
//        if($event->model->owner instanceof Exhibition)
//        {
//            $check = Likes::whereId($event->model->id)->first();
//            if($check)
//            {
//                $event->model->owner->user->notify(new ArtworkLikedNotification($check));
//                return;
//            }
//        }
    }
}
