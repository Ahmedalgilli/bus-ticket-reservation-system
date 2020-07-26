<?php

use Illuminate\Database\Seeder;
use App\Ticket;
use App\Bus;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = factory(Ticket::class, 10)->create();
        
        $trip = Bus::find(1);
        $bus = Bus::find(2);

        foreach ($tickets as $ticket) {
            $bus->tickets()->attach($ticket);
            $trip->tickets()->attach($ticket);
        }

    }
}
