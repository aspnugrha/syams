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
            'description' => "<p>Syams is a fashion manufacturing company that delivers more than just clothing. We create apparel through a process driven by precision, creativity, and a measured design approach. Syams is not merely focused on production, but serves as a channel to express the values, quality, and meaning behind a brand idea.</p><p>With 10 years of experience and the trust of more than a thousand brands, Syams has expanded into international markets while strengthening its presence in Indonesia. Each product is crafted by skilled hands with high quality standards, durability, and strong commercial value. Turning the Impossible into Wearable reflects our commitment to transforming creative vision into fashion that is relevant and enduring.</p>",
            'pavicon' => 'syams-pavicon.png',
            'logo' => 'syams-logo.png',
            'email' => 'syamsmakmurglobalindo@gmail.com',
            'phone_number' => '6285765887344',
            'instagram' => 'syamsmanufacturing',
            'alamat' => 'Syams Manufacturing Globalindo
                        Jl. Mekar Subur No. 9–11, Cijerah
                        Bandung, West Java 40213
                        Indonesia',
            'privacy' => "<p>As a multinational manufacturing company, Syams applies strict data security standards to protect all information from unauthorized access, misuse, or data breaches. All information is managed by a dedicated internal team responsible for safeguarding all private information belonging to you through controlled and professional data management practices, ensuring it remains secure, trusted, and fully protected at all times</p>",
            'refund' => "<p>Syams holds full responsibility for any production-related errors. In the event of an unacceptable error proven to originate from Syams, including major specification discrepancies, significant manufacturing defects, or quality failures. We guarantee a fair resolution, including a refund, based on an objective and transparent evaluation.</p>",
            'shipping' => "<p>Syams is committed to ensuring that every product is shipped safely, handled professionally, and monitored with clear accountability until it reaches its destination. As a multinational manufacturing company, we view shipping as an integral part of our service responsibility. Therefore, we take full responsibility for coordination, communication, and shipment handling through trusted logistics partners in a transparent and accountable manner, and we actively assist in resolving any issues related to loss or damage that may occur during transit.</p>",
        ]);
    }
}
