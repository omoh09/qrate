<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Items;
use Faker\Generator as Faker;

$factory->define(Items::class, function (Faker $faker) {
    return [
        'folder_id' => $faker->numberBetween(1,10),
        'artwork_id' => $faker->numberBetween(1,10),
    ];
});
