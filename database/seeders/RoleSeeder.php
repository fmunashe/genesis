<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'Super Admin', 'description' => 'Super Admin Role'],
            ['id' => 2, 'name' => 'Company Admin', 'description' => 'Company Admin Role'],
            ['id' => 3, 'name' => 'Regular User', 'description' => 'Regular User Role'],
        ];

        foreach ($roles as $role) {
            Role::query()->firstOrCreate($role, $role);
        }
    }
}
