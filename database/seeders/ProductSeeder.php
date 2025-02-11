<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Array of products to be inserted with quantity
        $products = [
            [
                'name' => 'Product 1',
                'price' => 29.99,
                'image' => 'product1.jpg',
                'quantity' => 100,
            ],
            [
                'name' => 'Product 2',
                'price' => 19.99,
                'image' => 'product2.jpg',
                'quantity' => 200,
            ],
            [
                'name' => 'Product 3',
                'price' => 49.99,
                'image' => 'product3.jpg',
                'quantity' => 150,
            ],
            [
                'name' => 'Product 4',
                'price' => 99.99,
                'image' => 'product4.jpg',
                'quantity' => 50,
            ],
            [
                'name' => 'Product 5',
                'price' => 59.99,
                'image' => 'product5.jpg',
                'quantity' => 80,
            ],
            [
                'name' => 'Product 6',
                'price' => 39.99,
                'image' => 'product6.jpg',
                'quantity' => 120,
            ],
            [
                'name' => 'Product 7',
                'price' => 89.99,
                'image' => 'product7.jpg',
                'quantity' => 30,
            ],
            [
                'name' => 'Product 8',
                'price' => 79.99,
                'image' => 'product8.jpg',
                'quantity' => 90,
            ],
            [
                'name' => 'Product 9',
                'price' => 69.99,
                'image' => 'product9.jpg',
                'quantity' => 110,
            ],
            [
                'name' => 'Product 10',
                'price' => 24.99,
                'image' => 'product10.jpg',
                'quantity' => 300,
            ]
        ];

        // Insert products into the products table
        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}
