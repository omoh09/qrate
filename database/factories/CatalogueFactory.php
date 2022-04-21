<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Catalogue;
use Faker\Generator as Faker;

$factory->define(Catalogue::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween(1,10),
    ];
});
