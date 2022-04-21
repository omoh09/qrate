<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Artworks;
use App\User;
use Faker\Generator as Faker;

$factory->define(Artworks::class, function (Faker $faker) {
    return [
        'user_id' =>User::inRandomOrder()->get()->first()->id,
        'title' => $faker->randomElement(['likey','more to the eyes','collage','nok art','ooni head','efik art','benin art']),
        'description'=> 'this is a nice artwork you can get from us at qrate',
        'dimension' => $faker->randomDigit,
        'price' => $faker->randomElement(['12343','42632','700','200','3','4',12]),
        'category_id' => \App\Categories::inRandomOrder()->first()->id,
        'sold' => $faker->boolean,
        'likes_count' => $faker->numberBetween(1,10),
        'sale_type' => $faker->numberBetween(1,2)
    ];
});
