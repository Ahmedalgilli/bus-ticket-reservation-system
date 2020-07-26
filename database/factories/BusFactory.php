<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bus;
use Faker\Generator as Faker;

$factory->define(Bus::class, function (Faker $faker) {
    $array = ['KH1','KH2','KH3'];
    return [
        // 'user_id' => $faker->numberBetween(1, 4),
        'user_id' => 1,
        'license_plate_number' => $array[random_int(0,2)].'-'.random_int(1, 9000),
        'name' => 'bus '.$faker->numberBetween(1, 9),
        'seats_number' => $faker->numberBetween(20, 45),
    ];
});
