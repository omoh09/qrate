<?php

use App\Likes;
use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Likes::class,10)->create();

        $users  = \App\User::all();

        foreach ($users as $user)
        {
            Likes::create([
                'user_id' => $user->id,
                'owner_type' => 'App\Post',
                'owner_id' => \App\Post::inRandomOrder()->first()->id
            ]);
            Likes::create([
                'user_id' => $user->id,
                'owner_type' => 'App\Artworks',
                'owner_id' => \App\Artworks::inRandomOrder()->first()->id
            ]);
        }
    }
}
