<?php

namespace Database\Seeders;

use App\Helpers\IdGenerator;
use App\Models\Products;
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
                'name' => 'Beanie Sublime',
                'category_id' => 'CTGRY2025112600006we823g',
                'description' => 'A lightweight, breathable cotton tee designed for everyday comfort. Featuring a minimalist chest print, this shirt pairs effortlessly with any casual outfit.',
                // 'cover' => 'bs.jpg',
                'image' => 'bs.jpg,bs1.jpg,bs2.jpg,knit-beanie-w-pearl.jpg,beanie.jpg',
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
                'name' => 'Knit Beanie',
                'category_id' => 'CTGRY2025112600006we823g',
                'description' => 'Classic straight-fit jeans crafted with stretchable denim for easy movement. The stonewashed finish adds a timeless rugged look suitable for daily wear.',
                // 'cover' => 'knit-beanie.jpg',
                'image' => 'knit-beanie.jpg',
                'size_qty_options' => null
            ],
            // [
            //     'name' => 'Beanie',
            //     'category_id' => 'CTGRY2025112600006we823g',
            //     'description' => 'A warm fleece hoodie made for comfort in chilly weather. Includes a roomy kangaroo pocket and adjustable drawstring hood with a modern casual silhouette.',
            //     'cover' => 'beanie.jpg',
            //     'image' => 'beanie.jpg',
            //     'size_qty_options' => json_encode([
            //         [
            //             'size' => 'S',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'M',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'L',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'XL',
            //             'qty' => ['25', '50', '100']
            //         ]
            //     ]),
            // ],
            // [
            //     'name' => 'Knit Beanie With Pearl',
            //     'category_id' => 'CTGRY2025112600006we823g',
            //     'description' => 'A soft knitted sweater with subtle ribbed details. Designed to deliver warmth without being bulky—perfect for layering during colder seasons.',
            //     'cover' => 'knit-beanie-w-pearl.jpg',
            //     'image' => 'knit-beanie-w-pearl.jpg',
            //     'size_qty_options' => json_encode([
            //         [
            //             'size' => 'S',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'M',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'L',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'XL',
            //             'qty' => ['25', '50', '100']
            //         ],
            //         [
            //             'size' => 'XXL',
            //             'qty' => ['25', '50', '100', '150']
            //         ]
            //     ]),
            // ],
            [
                'name' => 'Knitwear Mohair Custom',
                'category_id' => 'CTGRY2025112600008hg4ey3',
                'description' => 'A soft knitted sweater with subtle ribbed details. Designed to deliver warmth without being bulky—perfect for layering during colder seasons.',
                // 'cover' => 'knitwear-mohair-custom.jpg',
                'image' => 'knitwear-mohair-custom.jpg',
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
            [
                'name' => 'Canvas Jacket',
                'category_id' => 'CTGRY202511260000707bsh3',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'canvas-jacket.jpg',
                'image' => 'canvas-jacket.jpg',
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
            [
                'name' => 'Fenching Jacket',
                'category_id' => 'CTGRY202511260000707bsh3',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'fenching-jacket.jpg',
                'image' => 'fenching-jacket.jpg',
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
            [
                'name' => 'Jacket Track Sublime',
                'category_id' => 'CTGRY202511260000707bsh3',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'jacket-track-sublime.jpg',
                'image' => 'jacket-track-sublime.jpg',
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
            [
                'name' => 'Work Jacket With Embroidery Patch',
                'category_id' => 'CTGRY202511260000707bsh3',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'work-jacket-with-embroidery-patch.jpg',
                'image' => 'work-jacket-with-embroidery-patch.jpg,work-jacket-with-embroidery-patch2.jpg',
                'size_qty_options' => json_encode([
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
                ]),
            ],
            [
                'name' => 'Leather Jaket With Embordir And Spray',
                'category_id' => 'CTGRY202511260000707bsh3',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'leather-jaket-with-embordir-and-spray1.jpg',
                'image' => 'leather-jaket-with-embordir-and-spray1.jpg,leather-jaket-with-embordir-and-spray2.jpg',
                'size_qty_options' => json_encode([
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
                ]),
            ],
            [
                'name' => 'Pants With Rhinestone Fading',
                'category_id' => 'CTGRY2025112600004kn0u9q',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'pants-with-rhinestone-fading.jpg',
                'image' => 'pants-with-rhinestone-fading.jpg',
                'size_qty_options' => json_encode([
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
                    ],
                    [
                        'size' => '32',
                        'qty' => ['25', '50', '100']
                    ],
                ]),
            ],
            [
                'name' => 'Hoodie Fading With Rhinestone',
                'category_id' => 'CTGRY2025112600002kl3qw8',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'hoodie-fading-with-rhinestone.jpg',
                'image' => 'hoodie-fading-with-rhinestone.jpg',
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
                ]),
            ],
            [
                'name' => 'Washing Hoodie',
                'category_id' => 'CTGRY2025112600002kl3qw8',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'washing-hoodie.jpg',
                'image' => 'washing-hoodie.jpg',
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
                ]),
            ],
            [
                'name' => 'Hoodie Zipper',
                'category_id' => 'CTGRY2025112600009hf7eh3',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'hoodie-zipper.jpg',
                'image' => 'hoodie-zipper.jpg',
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
                ]),
            ],
            [
                'name' => 'Jeans Rhinestone',
                'category_id' => 'CTGRY2025112600005bv7Ghe',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'jeans-rhinestone1.jpg',
                'image' => 'jeans-rhinestone1.jpg,jeans-rhinestone2.jpg',
                'size_qty_options' => json_encode([
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
                    ],
                    [
                        'size' => '32',
                        'qty' => ['25', '50', '100']
                    ],
                ]),
            ],
            [
                'name' => 'Jorts Jeans',
                'category_id' => 'CTGRY2025112600005bv7Ghe',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                // 'cover' => 'jorts-jeans1.jpg',
                'image' => 'jorts-jeans1.jpg,jorts-jeans2.jpg',
                'size_qty_options' => json_encode([
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
                    ],
                    [
                        'size' => '32',
                        'qty' => ['25', '50', '100']
                    ],
                ]),
            ],
            
            // order
            [
                'type' => 'ORDER',
                'name' => 'Shirt Unisex Oversize',
                'category_id' => 'CTGRY2025112600001aaZNlw',
                'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
                'cover' => null,
                'image' => 'blank-shirt-white.png',
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
                'material_color_options' => json_encode([
                    Products::getDataMaterials('Baby Terry Cotton (220gsm)'),
                    Products::getDataMaterials('Cotton Striper (20s)'),
                    Products::getDataMaterials('Cotton Combed BCI Supersoft (24s)'),
                ]),
                'sablon_type' => 'Screen Printing,DTF',
                'is_bordir' => 1,
            ],
            // [
            //     'type' => 'ORDER',
            //     'name' => 'Hoodie Unisex Oversize',
            //     'category_id' => 'CTGRY2025112600002kl3qw8',
            //     'description' => 'Lightweight tapered pants with a clean fit and elastic waistband. Ideal for both casual days and semi-formal occasions, offering all-day comfort and style.',
            //     'cover' => null,
            //     'image' => 'hoodie-oversize.jpg',
            //     'size_qty_options' => json_encode([
            //         [
            //             'size' => 'S',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'M',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'L',
            //             'qty' => ['25', '50', '100']
            //         ], 
            //         [
            //             'size' => 'XL',
            //             'qty' => ['25', '50', '100']
            //         ]
            //     ]),
            //     'material_color_options' => json_encode([
            //         [
            //             'material' => 'Cutton 16s',
            //             'colors' => [
            //                 [
            //                     'color' => 'Lavender Crush',
            //                     'color_code' => '#B388EB'
            //                 ],
            //                 [
            //                     'color' => 'Dusty Rose',
            //                     'color_code' => '#E5989B'
            //                 ],
            //             ],
            //         ], 
            //         [
            //             'material' => 'Cutton 26s',
            //             'colors' => [
            //                 [
            //                     'color' => 'Soft Lilac',
            //                     'color_code' => '#CDB4DB'
            //                 ],
            //                 [
            //                     'color' => 'Jet Black',
            //                     'color_code' => '#0B0B0B'
            //                 ],
            //             ],
            //         ], 
            //     ]),
            //     'sablon_type' => 'Screen Printing,DTF',
            //     'is_bordir' => 0,
            // ],
        ];

        foreach($data as $index => $item){
            DB::table('products')->insert([
                'id' => IdGenerator::generate('PRDCT', 'products'),
                'type' => (isset($item['type']) ? $item['type'] : 'SHOWCASE'),
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'slug' => str_replace(' ', '-', strtolower($item['name'])),
                'description' => $item['description'],
                'cover' => $item['cover'],
                'image' => $item['image'],
                'size_qty_options' => $item['size_qty_options'],
                'material_color_options' => (isset($item['material_color_options']) ? $item['material_color_options'] : null),
                'sablon_type' => (isset($item['sablon_type']) ? $item['sablon_type'] : null),
                'is_bordir' => (isset($item['is_bordir']) ? $item['is_bordir'] : 0),
                'active' => 1,
                'main_product' => (($index <= 3) ? 1 : 0),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
