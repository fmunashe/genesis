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
            ['id' => 1, 'name' => 'Early Bird', 'description' => 'Early Bird Ticket Type'],
            ['id' => 2, 'name' => 'Final Release', 'description' => 'Final Release Ticket Type'],
            ['id' => 3, 'name' => 'Regular', 'description' => 'Regular Ticket Type']
        ];

        foreach ($types as $type) {
            TicketType::query()->firstOrCreate($type, $type);
        }
    }
}
