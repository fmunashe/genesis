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
            ['id' => 2, 'name' => 'Farai', 'email' => 'zihovem@gmail.com','password'=>Hash::make('password'),'email_verified_at'=>Carbon::now(), 'role_id' => 1, 'company_id' => 1],
            ['id' => 3, 'name' => 'Ranga', 'email' => 'ranga@gmail.com','password'=>Hash::make('password'),'email_verified_at'=>Carbon::now(), 'role_id' => 1, 'company_id' => 1]
        ];

        foreach ($users as $user) {
            User::query()->firstOrCreate($user, $user);
        }
    }
}
