<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Route;
use Faker\Generator as Faker;

$factory->define(Route::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'from' => $faker->state,
        'to' => $faker->state,
        'duration' => $faker->numberBetween(2, 12),
    ];
});
