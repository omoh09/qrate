<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comments;
use Faker\Generator as Faker;

$factory->define(Comments::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::inRandomOrder()->first()->id,
        'body' => $faker->realText(),
        'owner_type' => $faker->randomElement(['App\Post','App\Artworks']),
        'owner_id' => $faker->numberBetween(1,10),
    ];
});
