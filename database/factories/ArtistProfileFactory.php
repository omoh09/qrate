<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use App\User;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->get()->first()->id,
        'username' => $faker->userName,
        'bio' => $faker->paragraph,
        'address' => $faker->address
    ];
});
