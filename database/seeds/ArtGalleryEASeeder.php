<?php

use Illuminate\Database\Seeder;

class ArtGalleryEASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $galleries = \App\User::whereRole(3)->get();
        $artists = \App\User::whereRole(2)->get();
        foreach ($galleries as $gallery)
        {
            $gallery->photos()->create();
            foreach ($artists as $artist)
            {
                $gallery->artists()->attach($artist->id);
                $gallery->photos->files()->create(
                    [
                        'url' => 'https://res.cloudinary.com/onifs-cloud/image/upload/v1604248092/Artworks/g1d0x2n6zlehj6ftok7a.png',
                        'thumbnail' => 'https://res.cloudinary.com/onifs-cloud/image/upload/v1603814736/thumbnail/ryglz3ayymomjudttu0b.jpg'
                    ]
                );
            }
        }
    }
}
