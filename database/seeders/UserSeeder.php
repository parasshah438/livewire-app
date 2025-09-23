<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample users for testing
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(30),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(25),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(20),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(15),
            ],
            [
                'name' => 'David Brown',
                'email' => 'david@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(10),
            ],
            [
                'name' => 'Lisa Garcia',
                'email' => 'lisa@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'Robert Davis',
                'email' => 'robert@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Emily Martinez',
                'email' => 'emily@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'created_at' => now()->subDays(1),
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::create($userData);
        }
    }
}
