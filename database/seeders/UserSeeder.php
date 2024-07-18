<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['id' => 1, 'name' => 'Kuda', 'email' => 'kuda@genesis.co.zw','password'=>Hash::make('password'),'email_verified_at'=>Carbon::now(), 'role_id' => 1, 'company_id' => 1],
            ['id' => 2, 'name' => 'Company User', 'email' => 'companyAdmin@genesis.co.zw','password'=>Hash::make('password'),'email_verified_at'=>Carbon::now(), 'role_id' => 2, 'company_id' => 1],
            ['id' => 3, 'name' => 'Regular User', 'email' => 'regularUser@genesis.co.zw','password'=>Hash::make('password'),'email_verified_at'=>Carbon::now(), 'role_id' => 3, 'company_id' => 1],
        ];

        foreach ($users as $user) {
            User::query()->firstOrCreate($user, $user);
        }
    }
}
