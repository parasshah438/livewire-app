<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $authors = ['John Doe', 'Jane Smith', 'Mike Johnson', 'Sarah Wilson', 'David Brown'];
        $images = [
            'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800',
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800',
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800',
            'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?w=800',
            'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800',
            'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800',
            'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800',
            'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800'
        ];

        for ($i = 1; $i <= 50; $i++) {
            Blog::create([
                'title' => $faker->sentence(6),
                'content' => $faker->paragraphs(5, true),
                'author' => $faker->randomElement($authors),
                'image' => $faker->randomElement($images),
                'likes' => $faker->numberBetween(0, 500),
                'comments' => $faker->numberBetween(0, 100),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}