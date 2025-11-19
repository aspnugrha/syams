<?php

namespace Database\Seeders;

use App\Helpers\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            [
                'id' => 'USR2000000000001SrkcfS',
                'name' => 'superadmin',
                'email' => 'superadmin@admin.com',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
            ],
        ];

        foreach($admin as $index => $item){
            DB::table('users')->insert([
                'id' => ($index == 0) ? $item['id'] : IdGenerator::generate('USR', 'users'),
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'active' => 1,
            ]);
        }
        
        $customer = [
            [
                'name' => 'customer',
                'email' => 'customer@gmail.com',
            ],
        ];

        foreach($customer as $item){
            DB::table('customers')->insert([
                'id' => IdGenerator::generate('CTMR', 'customers'),
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'active' => 1,
            ]);
        }
    }
}
