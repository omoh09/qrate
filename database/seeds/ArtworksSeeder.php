<?php

use App\Artworks;
use Illuminate\Database\Seeder;

class ArtworksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Artworks::class,20)->create();

        $artworks = Artworks::all();
        foreach ($artworks as $artwork)
        {
            $artwork->files()->create(
                [
                    'url' => 'https://res.cloudinary.com/dv1ul1mxv/image/upload/v1601423253/1434_aHR0cHM6Ly9zMy5jb2ludGVsZWdyYXBoLmNvbS9zdG9yYWdlL3VwbG9hZHMvdmlldy84ZjM3YTJmZWY3Y2ZmZDFlYTM0MmM5NzUwMDcyNTEwYS5qcGc_pxhckb.jpg',
                    'thumbnail' => 'https://res.cloudinary.com/dv1ul1mxv/image/upload/v1601423253/1434_aHR0cHM6Ly9zMy5jb2ludGVsZWdyYXBoLmNvbS9zdG9yYWdlL3VwbG9hZHMvdmlldy84ZjM3YTJmZWY3Y2ZmZDFlYTM0MmM5NzUwMDcyNTEwYS5qcGc_pxhckb.jpg'
                ]
            );
            $artwork->video()->create(
                [
                    'url' => 'https://res.cloudinary.com/dv1ul1mxv/video/upload/v1610727256/Painting_Short_-_Sponge_Brush_m52e55.mp4'
                ]
            );
            if($artwork->sale_type == 2)
            {
                if((int) $artwork->id % 2 == 0)
                {
                    $artwork->auction()->create(
                        [
                            'bid_start' => Now()->toDateTime(),
                            'bid_end' =>  Now()->addDays()->toDateTime(),
                            'approved' => true
                        ]
                    );
                }else{
                    $artwork->auction()->create(
                        [
                            'bid_start' => Now()->subMonth()->subHours()->toDateTime(),
                            'bid_end' =>  Now()->subMonth()->toDateTime(),
                            'approved' => true
                        ]
                    );
                }
            }else {
                $artwork->auction()->create(
                    [
                        'bid_start' => Now()->addMonth()->toDateTime(),
                        'bid_end' =>  Now()->addMonth()->addDays()->toDateTime(),
                        'approved' => true
                    ]
                );
            }
        }
    }
}
