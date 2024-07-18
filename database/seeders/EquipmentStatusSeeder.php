<?php

namespace Database\Seeders;

use App\Models\EquipmentStatus;
use Illuminate\Database\Seeder;

class EquipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'status' => 'Old'],
            ['id' => 2, 'status' => 'Brand New'],
            ['id' => 3, 'status' => 'Fairly New']
        ];

        foreach ($statuses as $status) {
            EquipmentStatus::query()->firstOrCreate($status, $status);
        }
    }
}
