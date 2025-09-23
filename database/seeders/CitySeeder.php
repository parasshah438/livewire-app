<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $california = State::where('name', 'California')->first();
        $texas = State::where('name', 'Texas')->first();
        $gujarat = State::where('name', 'Gujarat')->first();

        $cities = [
            // California cities
            ['name' => 'Los Angeles', 'state_id' => $california->id],
            ['name' => 'San Francisco', 'state_id' => $california->id],
            ['name' => 'San Diego', 'state_id' => $california->id],
            ['name' => 'Sacramento', 'state_id' => $california->id],
            ['name' => 'San Jose', 'state_id' => $california->id],

            // Gujarat cities
            ['name' => 'Ahmedabad', 'state_id' => $gujarat->id],
            ['name' => 'Surat', 'state_id' => $gujarat->id],
            ['name' => 'Vadodara', 'state_id' => $gujarat->id],
            ['name' => 'Rajkot', 'state_id' => $gujarat->id],
            ['name' => 'Bhavnagar', 'state_id' => $gujarat->id],
            
            // Texas cities
            ['name' => 'Houston', 'state_id' => $texas->id],
            ['name' => 'Dallas', 'state_id' => $texas->id],
            ['name' => 'Austin', 'state_id' => $texas->id],
            ['name' => 'San Antonio', 'state_id' => $texas->id],
            ['name' => 'Fort Worth', 'state_id' => $texas->id],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}