<?php

use Illuminate\Database\Seeder;
use App\Trip;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Trip::class, 5)->create();
    }
}
