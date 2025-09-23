<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Australia', 'code' => 'AU'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'Brazil', 'code' => 'BR'],
            ['name' => 'Mexico', 'code' => 'MX'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}