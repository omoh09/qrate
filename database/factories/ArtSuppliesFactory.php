<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\ArtSupply::class, function (Faker $faker) {

    $user = \App\User::inRandomOrder()->where('role',4)->first();
    return
        [
                'user_id' => $user->id,
                'title' => $faker->randomElement(['paint brush ','wall papers','frames','ink','glue','pen','chisel']),
                'description' => $faker->sentence,
                'price' => $faker->randomElement(['12343','42632','700','200','3','4',12]),
                'category_id' => \App\SuppliesCategory::inRandomOrder()->get()->first()->id,
                'sold' => $faker->boolean
        ];
});
