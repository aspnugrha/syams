<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'CTGRY2025112600001aaZNlw',
                'name' => 'T-shirt'
            ], 
            [
                'id' => 'CTGRY2025112600002kl3qw8',
                'name' => 'Hoodie'
            ], 
            [
                'id' => 'CTGRY2025112600003we6v6m',
                'name' => 'Sweeter'
            ], 
            [
                'id' => 'CTGRY2025112600004kn0u9q',
                'name' => 'Pants'
            ], 
            [
                'id' => 'CTGRY2025112600005bv7Ghe',
                'name' => 'Jeans'
            ],
            [
                'id' => 'CTGRY2025112600006we823g',
                'name' => 'Beanie'
            ],
            [
                'id' => 'CTGRY202511260000707bsh3',
                'name' => 'Jacket'
            ],
            [
                'id' => 'CTGRY2025112600008hg4ey3',
                'name' => 'Knitwear'
            ],
            [
                'id' => 'CTGRY2025112600009hf7eh3',
                'name' => 'Hoodie Zipper'
            ],
        ];
        foreach($data as $item){
            DB::table('categories')->insert([
                'id' => $item['id'],
                'name' => $item['name'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
