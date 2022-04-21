<?php

namespace App\Listeners;

use App\Events\NewPost;
use App\Notifications\NewPostNotification;
use App\Post;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewPostListener implements ShouldQueue
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

    public function shouldQueue(NewPost $event)
    {
        return true;
    }

    /**
     * Handle the event.
     *
     * @param  NewPost  $event
     * @return void
     */
    public function handle(NewPost $event)
    {
        $check = Post::whereId($event->post->id)->first();
        if($check){
            $users = $event->post->user->followers()->where(['notification_on' => true,'post_notification' => true])->get();
            Notification::send($users, new NewPostNotification($event->post));
        }
    }
}
