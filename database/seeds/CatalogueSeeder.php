<?php

use App\Catalogue;
use Illuminate\Database\Seeder;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();

        foreach ($users as $user)
        {
            $user->catalogue()->create();
            $user->catalogue->folders()->create(['name' => 'sample']);
            $artwork = \App\Artworks::inRandomOrder()->first();
            $user->catalogue->folders->first()->artworks()->attach($artwork->id);
        }
    }
}
