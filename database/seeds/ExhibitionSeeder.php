<?php

use App\Exhibition;
use Illuminate\Database\Seeder;

class ExhibitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory( Exhibition::class,20)->create();

        $exhibitions = Exhibition::all();
        foreach ($exhibitions as $exhibition)
        {
            $exhibition->files()->create(
                [
                    'url' => 'https://res.cloudinary.com/dv1ul1mxv/image/upload/v1601423253/1434_aHR0cHM6Ly9zMy5jb2ludGVsZWdyYXBoLmNvbS9zdG9yYWdlL3VwbG9hZHMvdmlldy84ZjM3YTJmZWY3Y2ZmZDFlYTM0MmM5NzUwMDcyNTEwYS5qcGc_pxhckb.jpg',
                    'thumbnail' => 'https://res.cloudinary.com/dv1ul1mxv/image/upload/v1601422646/img11_cmoszl.png'
                ]
            );

            $exhibition->video()->create(
                [
                    'url' => 'https://res.cloudinary.com/dv1ul1mxv/video/upload/v1610727256/Painting_Short_-_Sponge_Brush_m52e55.mp4'
                ]
            );
        }
    }
}
