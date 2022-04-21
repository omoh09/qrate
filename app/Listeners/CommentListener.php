<?php

namespace App\Listeners;

use App\Post;
use App\Artworks;
use App\Comments;
use App\Events\CommentEvent;
use App\Notifications\NewCommentNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentListener implements ShouldQueue
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
     * @param  CommentEvent  $event
     * @return void
     */
    public function handle(CommentEvent $event)
    {
        if($event->model->owner->user_id == $event->model->user->id || (bool) $event->model->owner->user->notification_on == false)
        {
            return;
        }    
        $check = Comments::whereId($event->model->id)->first();
        if($check)
        {
            $event->model->owner->user->notify(new NewCommentNotification($check));
            return;
        }
       }
}
