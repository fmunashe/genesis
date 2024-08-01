<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            ['ticket_type_id' => 1, 'eventName' => 'Kaos', 'eventVenue' => 'Padendere', 'price' => 10, 'ageRestriction' => 18, 'eventDate' => Carbon::now()->addDays(2)->format('Y-m-d'), 'startTime' => Carbon::now()->addDays(3), 'endTime' => Carbon::now()->addDays(3)->addHours(5), 'entrance' => 'Test entrance gate 2', 'status' => 1],
            ['ticket_type_id' => 2, 'eventName' => 'Kaos', 'eventVenue' => 'Padendere', 'price' => 20, 'ageRestriction' => 18, 'eventDate' => Carbon::now()->addDays(5)->format('Y-m-d'), 'startTime' => Carbon::now()->addDays(4), 'endTime' => Carbon::now()->addDays(4)->addHours(3), 'entrance' => 'Test entrance gate 2', 'status' => 1],
            ['ticket_type_id' => 3, 'eventName' => 'Kaos', 'eventVenue' => 'Padendere', 'price' => 5, 'ageRestriction' => 18, 'eventDate' => Carbon::now()->addDays(10)->format('Y-m-d'), 'startTime' => Carbon::now()->addDays(5), 'endTime' => Carbon::now()->addDays(5)->addHours(2), 'entrance' => 'Test entrance gate 2', 'status' => 1]
        ];

        foreach ($tickets as $ticket) {
            Ticket::query()->firstOrCreate($ticket, $ticket);
        }
    }
}
