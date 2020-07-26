<?php

use App\User;
use App\Account;
use App\Contact;
use App\Organization;
use App\Ticket;
use App\Bus;
use App\Trip;
use App\Route;
use App\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'user@admin.com',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'owner' => false,
        ]);

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(BusSeeder::class);
        // $this->call(TripSeeder::class);

        factory(Bus::class, 5)->create();
        factory(Route::class, 5)->create();
        $trips = factory(Trip::class, 2)->create();
        $customers = factory(Customer::class, 5)->create();
        // $bus = Bus::find(2);
        
        foreach ($trips as $trip) {
            for ($i=0; $i < $trip->seats_number; $i++) { 
                $ticket = $trip->tickets()->create([ 'user_id' => 1, 'bus_id' => $trip->bus_id , 'customer_id' => $customers->random()->id, 'price' => $trip->price, 'seat_number' => $i+1 ]);
                // $bus->tickets()->attach($ticket);
            }
        }

    }
}
