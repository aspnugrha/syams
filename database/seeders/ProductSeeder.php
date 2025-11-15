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
                'name' => 'Hoddie A',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe? Voluptatum porro, repellat doloremque tenetur iste, doloribus veniam, explicabo qui blanditiis sint dolores commodi nam recusandae laudantium illo fugiat tempore.',
                'cover' => 'banner1.png',
                'image' => 'up1.png',
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
                'name' => 'Hoddie B',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe? Voluptatum porro, repellat doloremque tenetur iste, doloribus veniam, explicabo qui blanditiis sint dolores commodi nam recusandae',
                'cover' => 'banner1.png',
                'image' => 'up2.png',
                'size_qty_options' => null
            ],
            [
                'name' => 'Hoddie C',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe? Voluptatum porro, repellat doloremque tenetur iste, doloribus veniam, explicabo qui blanditiis sint',
                'cover' => 'banner1.png',
                'image' => 'up3.png',
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
                'name' => 'Hoddie D',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe?',
                'cover' => 'banner1.png',
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
                    ],
                    [
                        'size' => 'XXL',
                        'qty' => ['25', '50', '100', '150']
                    ]
                ]),
            ],
            // under
            [
                'name' => 'Pants A',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe? Voluptatum porro, repellat doloremque tenetur iste, doloribus veniam, explicabo qui blanditiis sint dolores commodi nam recusandae laudantium illo fugiat tempore.',
                'cover' => 'banner2.png',
                'image' => 'u1.png',
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
            [
                'name' => 'Pants B',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe? Voluptatum porro, repellat doloremque tenetur iste, doloribus veniam, explicabo qui blanditiis sint dolores commodi nam recusandae',
                'cover' => 'banner2.png',
                'image' => 'u2.png',
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
            [
                'name' => 'Pants C',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, saepe? Voluptatum porro, repellat doloremque tenetur iste, doloribus veniam, explicabo qui blanditiis sint',
                'cover' => 'banner2.png',
                'image' => 'u3.png',
                'size_qty_options' => null,
            ],
        ];

        foreach($data as $item){
            DB::table('products')->insert([
                'id' => IdGenerator::generate('PRDCT', 'products'),
                'name' => $item['name'],
                'slug' => str_replace(' ', '-', strtolower($item['name'])),
                'description' => $item['description'],
                'cover' => $item['cover'],
                'image' => $item['image'],
                'size_qty_options' => $item['size_qty_options'],
                'active' => 1,
            ]);
        }
    }
}
