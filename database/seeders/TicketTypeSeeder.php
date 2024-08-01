<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['id' => 1, 'name' => 'VIP', 'description' => 'VIP Ticket Type'],
            ['id' => 2, 'name' => 'VVIP', 'description' => 'VVIP Ticket Type'],
            ['id' => 3, 'name' => 'Regular', 'description' => 'Regular Ticket Type']
        ];

        foreach ($types as $type) {
            TicketType::query()->firstOrCreate($type, $type);
        }
    }
}
