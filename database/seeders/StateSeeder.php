<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usCountry = Country::where('code', 'US')->first();
        $caCountry = Country::where('code', 'CA')->first();
        $inCountry = Country::where('code', 'IN')->first();


        $states = [
            // US States
            ['name' => 'California', 'code' => 'CA', 'country_id' => $usCountry->id],
            ['name' => 'Texas', 'code' => 'TX', 'country_id' => $usCountry->id],
            ['name' => 'New York', 'code' => 'NY', 'country_id' => $usCountry->id],
            ['name' => 'Florida', 'code' => 'FL', 'country_id' => $usCountry->id],
            ['name' => 'Illinois', 'code' => 'IL', 'country_id' => $usCountry->id],

            // Indian States
            ['name' => 'Maharashtra', 'code' => 'MH', 'country_id' => $inCountry->id],
            ['name' => 'Karnataka', 'code' => 'KA', 'country_id' => $inCountry->id],
            ['name' => 'Tamil Nadu', 'code' => 'TN', 'country_id' => $inCountry->id],
            ['name' => 'Gujarat', 'code' => 'GJ', 'country_id' => $inCountry->id],
            ['name' => 'West Bengal', 'code' => 'WB', 'country_id' => $inCountry->id],

            // Canadian Provinces
            ['name' => 'Ontario', 'code' => 'ON', 'country_id' => $caCountry->id],
            ['name' => 'Quebec', 'code' => 'QC', 'country_id' => $caCountry->id],
            ['name' => 'British Columbia', 'code' => 'BC', 'country_id' => $caCountry->id],
            ['name' => 'Alberta', 'code' => 'AB', 'country_id' => $caCountry->id],
            ['name' => 'Manitoba', 'code' => 'MB', 'country_id' => $caCountry->id],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}