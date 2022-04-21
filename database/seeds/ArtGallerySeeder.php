<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\ArtGallery as Gallery;

class ArtGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = \App\User::where('role' ,3)->get();
        foreach ($users as $user){
            Gallery::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'location' => $faker->state . $faker->country,
                'picture' => $faker->imageUrl($width = 300, $height = 300, 'cats', true, 'Faker'),
                'address' => $faker->address,
                'description' => $faker->text,
            ]);
        }
    }
}
