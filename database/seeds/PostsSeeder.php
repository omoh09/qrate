<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class,100)->create();

        $posts = Post::all();

        foreach ($posts as $post)
        {
            $post->files()->create(
                [
                    'url' => 'https://res.cloudinary.com/onifs-cloud/image/upload/v1604253241/Artworks/k5ccoqzlrbyta9ysc3mz.png',
                    'thumbnail' => 'https://res.cloudinary.com/onifs-cloud/image/upload/v1604251409/thumbnail/jgz84ddnpoi9ufuo2emd.png'
                ]
            );
        }

    }
}
