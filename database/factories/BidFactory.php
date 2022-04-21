<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bid;
use Faker\Generator as Faker;

$factory->define(Bid::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1,10),
        'artwork_id' => $faker->numberBetween(1,10),
        'amount' => $faker->randomNumber(4,true),
        'status' => $faker->randomElement([0,1,2]),
    ];
});
