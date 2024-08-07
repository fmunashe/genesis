<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['id' => 1, 'name' => "Synth Music", 'contact' => '263771321534', 'address' => 'The Hub 14 Hind head Avenue,Chisipite, Harare,Zimbabwe']
        ];

        foreach ($companies as $company) {
            Company::query()->firstOrCreate($company, $company);
        }
    }
}
