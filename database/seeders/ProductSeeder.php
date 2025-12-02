<?php

namespace Database\Seeders;

use App\Helpers\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // upper
            [
                'name' => 'T-Shirt Urban Drift Tee',
                'category_id' => 'CTGRY2025112600001aaZNlw',
                'description' => 'A lightweight, breathable cotton tee designed for everyday comfort. Featuring a minimalist chest print, this shirt pairs effortlessly with any casual outfit.',
                'cover' => 'bg-2.jpg',
                'image' => 'up1.png,up2.png',
                'size_qty_options' => json_encode([
                    [
                        'size' => 'S',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'M',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'L',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'XL',
                        'qty' => ['25', '50', '100', '150', '200']
                    ]
                ]),
            ],
            [
                'name' => 'Jeans Stonewash Flex Denim',
                'category_id' => 'CTGRY2025112600005bv7Ghe',
                'description' => 'Classic straight-fit jeans crafted with stretchable denim for easy movement. The stonewashed finish adds a timeless rugged look suitable for daily wear.',
                'cover' => 'bg-3.jpg',
                'image' => 'up3.png',
                'size_qty_options' => null
            ],
            [
                'name' => 'Hoodie CozyTrail Pullover Hoodie',
                'category_id' => 'CTGRY2025112600002kl3qw8',
                'description' => 'A warm fleece hoodie made for comfort in chilly weather. Includes a roomy kangaroo pocket and adjustable drawstring hood with a modern casual silhouette.',
                'cover' => 'bg-4.jpg',
                'image' => 'up4.png',
                'size_qty_options' => json_encode([
                    [
                        'size' => 'S',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'M',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'L',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'XL',
                        'qty' => ['25', '50', '100']
                    ]
                ]),
            ],
            [
                'name' => 'Sweater Nordic Knit Essential Sweater',
                'category_id' => 'CTGRY2025112600003we6v6m',
                'description' => 'A soft knitted sweater with subtle ribbed details. Designed to deliver warmth without being bulky—perfect for layering during colder seasons.',
                'cover' => 'bg-5.jpg',
                'image' => 'u1.png',
                'size_qty_options' => json_encode([
                    [
                        'size' => 'S',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'M',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'L',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => 'XL',
                        'qty' => ['25', '50', '100']
                    ],
                    [
                        'size' => 'XXL',
                        'qty' => ['25', '50', '100', '150']
                    ]
                ]),
            ],
            // under
            [
                'name' => 'Pants AeroLite Tapered Pants',
                'category_id' => 'CTGRY2025112600004kn0u9q',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                'cover' => 'bg-6.jpg',
                'image' => 'u2.png,u3.png',
                'size_qty_options' => json_encode([
                    [
                        'size' => '28',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => '29',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => '30',
                        'qty' => ['25', '50', '100']
                    ], 
                    [
                        'size' => '31',
                        'qty' => ['25', '50', '100']
                    ]
                ]),
            ],
        ];

        foreach($data as $index => $item){
            DB::table('products')->insert([
                'id' => IdGenerator::generate('PRDCT', 'products'),
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'slug' => str_replace(' ', '-', strtolower($item['name'])),
                'description' => $item['description'],
                'cover' => $item['cover'],
                'image' => $item['image'],
                'size_qty_options' => $item['size_qty_options'],
                'active' => 1,
                'main_product' => (($index == 0 || $index == 3) ? 1 : 0),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
