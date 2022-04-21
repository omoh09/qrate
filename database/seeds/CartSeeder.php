<?php

use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
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
            $artworks = \App\Artworks::inRandomOrder()->get()->take(4);
            $supplies = \App\ArtSupply::inRandomOrder()->get()->take(5);
            foreach ($artworks as $artwork)
            {
                $artwork->toCart()->create(['user_id' => $user->id, 'quantity' => 1]);
            }
            foreach ($supplies as $supply)
            {
                $supply->toCart()->create(['user_id' => $user->id, 'quantity' => 1]);
            }
        }
    }
}
