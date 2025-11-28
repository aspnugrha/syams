<?php

namespace Database\Seeders;

use App\Helpers\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_profiles')->insert([
            'id' => 'CPNPFL20000000rtg8ly',
            'name' => 'Syams Manufacturing',
            'pavicon' => 'syams-pavicon.jpg',
            'logo' => 'syams-logo.png',
            'email' => 'syamsmakmurnglobalindo@gmail.com',
            'phone_number' => '628',
        ]);
    }
}
