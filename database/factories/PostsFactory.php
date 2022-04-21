<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->get()->first()->id,
        'body' => $faker->realText(),
        'category_id' => $faker->numberBetween(1,10),
    ];
});
