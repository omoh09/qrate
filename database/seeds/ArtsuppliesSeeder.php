<?php

use Illuminate\Database\Seeder;

class ArtsuppliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ArtSupply::class,20)->create();

        $supplies = \App\ArtSupply::all();

          foreach ($supplies as $supply) {
              $supply->files()->create(
                  [
                       'url' => 'https://res.cloudinary.com/dv1ul1mxv/image/upload/v1601423253/1434_aHR0cHM6Ly9zMy5jb2ludGVsZWdyYXBoLmNvbS9zdG9yYWdlL3VwbG9hZHMvdmlldy84ZjM3YTJmZWY3Y2ZmZDFlYTM0MmM5NzUwMDcyNTEwYS5qcGc_pxhckb.jpg',
                      'thumbnail' => 'https://res.cloudinary.com/dv1ul1mxv/image/upload/v1601423253/1434_aHR0cHM6Ly9zMy5jb2ludGVsZWdyYXBoLmNvbS9zdG9yYWdlL3VwbG9hZHMvdmlldy84ZjM3YTJmZWY3Y2ZmZDFlYTM0MmM5NzUwMDcyNTEwYS5qcGc_pxhckb.jpg'
                  ]
              );
          }

          }
}
