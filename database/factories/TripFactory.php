<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trip;
use Faker\Generator as Faker;
use App\Route;
use App\Bus;

$factory->define(Trip::class, function (Faker $faker) {
    // $array = array ('1KG','2KG','3KG', '4KG')
    return [
        'user_id' => 1,
        'created_by_employee_id' => 3,
        'bus_id' => $faker->numberBetween(1, 5),
        'route_id' => $faker->numberBetween(1, 5),
        'seats_number' => 45,
        'price' => $faker->numberBetween(500, 1000),
        'weight' => $faker->randomElement(['1KG','2KG','3KG', '4KG']),
        'date' => $faker->dateTime
    ];
});
