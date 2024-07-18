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
            ['id' => 1, 'name' => "Genesis Real Estate Africa", 'contact' => '263771321534', 'address' => 'The Hub 14 Hind head Avenue,Chisipite, Harare,Zimbabwe'],
            ['id' => 2, 'name' => "Delta Beverages", 'contact' => '263771321556', 'address' => 'Borrowdale Harare'],
            ['id' => 3, 'name' => "Alliance Insurance", 'contact' => '263771321509', 'address' => 'Borrowdale Harare'],
        ];

        foreach ($companies as $company) {
            Company::query()->firstOrCreate($company, $company);
        }
    }
}
