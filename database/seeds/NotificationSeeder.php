<?php

use App\Notifications\FollowedNotification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \App\Post::all();
        foreach($posts as $post)
        {
            $like =  $post->likes()->create(['user_id' => \App\User::inRandomOrder()->first()->id]);
            $like->owner->user->notify(new \App\Notifications\PostLikedNotification($like));
        }
        $users = \App\User::all();
        foreach ($users as $user)
        {
            $artwork = \App\Artworks::where('sale_type',1)->inRandomOrder()->first();
//            $auction = \App\Artworks::where('sale_type',2)->inRandomOrder()->first();
            $comment = \App\Comments::inRandomOrder()->first();
            $like = $artwork->likes()->create(['user_id' => $user->id]);
            $like->owner->user->notify(new \App\Notifications\ArtworkLikedNotification($like));
            $user->notify(new FollowedNotification(\App\User::inRandomOrder()->first()));
            $user->notify(new \App\Notifications\CommentNotification($comment));
        }

    }
}
