<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports', 'Toys', 'Beauty', 'Automotive'];
        
        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'category' => 'Electronics', 'price' => 79.99, 'description' => 'High-quality wireless headphones with noise cancellation'],
            ['name' => 'Smartphone Case', 'category' => 'Electronics', 'price' => 24.99, 'description' => 'Durable protective case for smartphones'],
            ['name' => 'Cotton T-Shirt', 'category' => 'Clothing', 'price' => 19.99, 'description' => '100% cotton comfortable t-shirt'],
            ['name' => 'Denim Jeans', 'category' => 'Clothing', 'price' => 59.99, 'description' => 'Classic fit denim jeans'],
            ['name' => 'Programming Book', 'category' => 'Books', 'price' => 39.99, 'description' => 'Learn modern web development'],
            ['name' => 'Garden Tools Set', 'category' => 'Home & Garden', 'price' => 89.99, 'description' => 'Complete set of essential garden tools'],
            ['name' => 'Basketball', 'category' => 'Sports', 'price' => 29.99, 'description' => 'Official size basketball'],
            ['name' => 'Building Blocks Set', 'category' => 'Toys', 'price' => 34.99, 'description' => 'Educational building blocks for kids'],
            ['name' => 'Face Moisturizer', 'category' => 'Beauty', 'price' => 24.99, 'description' => 'Hydrating face moisturizer for all skin types'],
            ['name' => 'Car Phone Mount', 'category' => 'Automotive', 'price' => 19.99, 'description' => 'Universal car phone mount'],
            ['name' => '4K Webcam', 'category' => 'Electronics', 'price' => 149.99, 'description' => 'Ultra HD webcam for streaming'],
            ['name' => 'Wireless Mouse', 'category' => 'Electronics', 'price' => 34.99, 'description' => 'Ergonomic wireless computer mouse'],
            ['name' => 'Hoodie Sweatshirt', 'category' => 'Clothing', 'price' => 44.99, 'description' => 'Warm and comfortable hoodie'],
            ['name' => 'Running Shoes', 'category' => 'Sports', 'price' => 99.99, 'description' => 'Professional running shoes'],
            ['name' => 'LED Desk Lamp', 'category' => 'Home & Garden', 'price' => 39.99, 'description' => 'Adjustable LED desk lamp'],
            ['name' => 'Fiction Novel', 'category' => 'Books', 'price' => 14.99, 'description' => 'Bestselling fiction novel'],
            ['name' => 'Puzzle Game', 'category' => 'Toys', 'price' => 19.99, 'description' => '1000 piece jigsaw puzzle'],
            ['name' => 'Lipstick Set', 'category' => 'Beauty', 'price' => 29.99, 'description' => 'Set of 5 different lipstick colors'],
            ['name' => 'Car Air Freshener', 'category' => 'Automotive', 'price' => 7.99, 'description' => 'Long-lasting car air freshener'],
            ['name' => 'Tablet Stand', 'category' => 'Electronics', 'price' => 24.99, 'description' => 'Adjustable tablet and phone stand'],
            ['name' => 'Dress Shirt', 'category' => 'Clothing', 'price' => 49.99, 'description' => 'Formal dress shirt for business'],
            ['name' => 'Yoga Mat', 'category' => 'Sports', 'price' => 39.99, 'description' => 'Non-slip yoga exercise mat'],
            ['name' => 'Cookbook', 'category' => 'Books', 'price' => 24.99, 'description' => 'Healthy recipe cookbook'],
            ['name' => 'Plant Pot Set', 'category' => 'Home & Garden', 'price' => 19.99, 'description' => 'Set of decorative plant pots'],
            ['name' => 'Remote Control Car', 'category' => 'Toys', 'price' => 79.99, 'description' => 'High-speed remote control car'],
            ['name' => 'Hair Straightener', 'category' => 'Beauty', 'price' => 59.99, 'description' => 'Professional hair straightener'],
            ['name' => 'Tire Pressure Gauge', 'category' => 'Automotive', 'price' => 12.99, 'description' => 'Digital tire pressure gauge'],
            ['name' => 'Bluetooth Speaker', 'category' => 'Electronics', 'price' => 69.99, 'description' => 'Portable waterproof bluetooth speaker'],
            ['name' => 'Winter Jacket', 'category' => 'Clothing', 'price' => 129.99, 'description' => 'Warm winter jacket with hood'],
            ['name' => 'Tennis Racket', 'category' => 'Sports', 'price' => 89.99, 'description' => 'Professional tennis racket'],
            ['name' => 'Science Textbook', 'category' => 'Books', 'price' => 59.99, 'description' => 'Comprehensive science textbook'],
            ['name' => 'Kitchen Knife Set', 'category' => 'Home & Garden', 'price' => 79.99, 'description' => 'Sharp stainless steel knife set'],
            ['name' => 'Board Game', 'category' => 'Toys', 'price' => 34.99, 'description' => 'Fun family board game'],
            ['name' => 'Perfume', 'category' => 'Beauty', 'price' => 89.99, 'description' => 'Luxury fragrance perfume'],
            ['name' => 'Car Charger', 'category' => 'Automotive', 'price' => 14.99, 'description' => 'Fast charging car adapter'],
            ['name' => 'Power Bank', 'category' => 'Electronics', 'price' => 44.99, 'description' => '20000mAh portable power bank'],
            ['name' => 'Sneakers', 'category' => 'Clothing', 'price' => 79.99, 'description' => 'Casual lifestyle sneakers'],
            ['name' => 'Swimming Goggles', 'category' => 'Sports', 'price' => 19.99, 'description' => 'Anti-fog swimming goggles'],
            ['name' => 'Art Book', 'category' => 'Books', 'price' => 34.99, 'description' => 'Beautiful art photography book'],
            ['name' => 'Coffee Maker', 'category' => 'Home & Garden', 'price' => 149.99, 'description' => 'Automatic drip coffee maker'],
            ['name' => 'Action Figure', 'category' => 'Toys', 'price' => 24.99, 'description' => 'Collectible action figure'],
            ['name' => 'Nail Polish Set', 'category' => 'Beauty', 'price' => 19.99, 'description' => 'Set of 10 nail polish colors'],
            ['name' => 'Car Seat Cover', 'category' => 'Automotive', 'price' => 49.99, 'description' => 'Universal car seat covers'],
            ['name' => 'USB Cable', 'category' => 'Electronics', 'price' => 9.99, 'description' => 'High-speed USB charging cable'],
            ['name' => 'Summer Dress', 'category' => 'Clothing', 'price' => 39.99, 'description' => 'Light and airy summer dress'],
            ['name' => 'Gym Bag', 'category' => 'Sports', 'price' => 49.99, 'description' => 'Spacious gym duffle bag'],
            ['name' => 'Travel Guide', 'category' => 'Books', 'price' => 19.99, 'description' => 'Complete travel guide book'],
            ['name' => 'Wall Clock', 'category' => 'Home & Garden', 'price' => 29.99, 'description' => 'Modern wall clock design'],
            ['name' => 'LEGO Set', 'category' => 'Toys', 'price' => 59.99, 'description' => 'Creative LEGO building set'],
            ['name' => 'Makeup Brush Set', 'category' => 'Beauty', 'price' => 39.99, 'description' => 'Professional makeup brush set'],
        ];

        foreach ($products as $index => $productData) {
            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => rand(5, 100),
                'category' => $productData['category'],
                'image' => 'https://picsum.photos/300/300?random=' . ($index + 1),
                'is_active' => true,
            ]);
        }
    }
}