<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Auction;
use Faker\Generator as Faker;

$factory->define(Bid::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'frame' => $faker->text,
        'minimum_bid' => $faker->text,
        'author' => $faker->text,
        'bid_start' => $faker->text,
        'bid_end' => $faker->text,
    ];
});
