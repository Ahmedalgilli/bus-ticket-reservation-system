<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ticket;
use Faker\Generator as Faker;
use App\Customer;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        // 'customer_id' => $faker->numberBetween(1, 10),
        'customer_id' => Customer::class,
        'status' => 1,
        'seat_number' => $faker->numberBetween(1, 45)
    ];
});
