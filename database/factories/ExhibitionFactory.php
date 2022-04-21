<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Exhibition;
use Faker\Generator as Faker;

$factory->define(Exhibition::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['live exhibition in ondo','live exhibition in akure','live exhibition in ijanikin','exhibiiton of the people','art x','real gallry','pepsi arts']),
        'desc' => 'this is a live exhibition ',
        'user_id' => \App\User::inRandomOrder()->whereRole(3)->get()->first()->id,
        'address' => $faker->address,
        'event_date' => $faker->randomElement([Now()->addMonths(2),Now()->addHour(),Now()->addDays(3),Now()->addDays(1),Now()->addDays(2),Now()]),
        'time' => $faker->randomElement([Now(),Now()->addSecond()]),
        'country' => $faker->country
    ];
});
