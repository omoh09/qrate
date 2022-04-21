<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Likes;
use App\User;
use Faker\Generator as Faker;

$factory->define(Likes::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'owner_type' => $faker->randomElement(['App\Post','App\Comments','App\Artworks']),
        'owner_id' => User::inRandomOrder()->first()->id
    ];
});
