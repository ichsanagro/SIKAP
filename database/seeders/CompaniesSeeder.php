<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
           [
                'name' => 'Dinas Komunikasi, Informasi dan Statistik Provinsi Bengkulu',
                'address' => 'Jl. Basuki Rahmat No.6, Sawah Lebar Baru, Kota Bengkulu, Bengkulu 38222',  
                'batch' => 1,
                'quota' => 8,
                'contact_person' => null,
                'contact_phone' => '0736-7325176',
            ],
            [
                'name' => 'Bagian Ortala (Kominfo Provinsi Bengkulu)',
                'address' => 'Jl. Basuki Rahmat No.6, Sawah Lebar Baru, Kota Bengkulu, Bengkulu 38222',  
                'batch' => 2,
                'quota' => 2,
                'contact_person' => null,
                'contact_phone' => '0736-7325176',
            ],
            [
                'name' => 'Dinas Komunikasi dan Informatika Kota Bengkulu',
                'address' => 'Jl. Jati Raya No.01, Kota Bengkulu, Bengkulu',  
                'batch' => 3,
                'quota' => 4,
                'contact_person' => null,
                'contact_phone' => '0736-21003',
            ],
            [
                'name' => 'PT Telkom Indonesia (cabang Bengkulu)',
                'address' => 'Jl. Kartini No.4, Bengkulu',  
                'batch' => 4,
                'quota' => 10,
                'contact_person' => null,
                'contact_phone' => '0732-21001',
            ],
            [
                'name' => 'Biznet Branch Bengkulu',
                'address' => 'Jl. Kapt. P. Tandean, RT.004/RW002, Jemb. Kecil, Kec. Singaran Pati, Kota Bengkulu, Bengkulu 38224',
                'batch' => 5,
                'quota' => 2,
                'contact_person' => null,
                'contact_phone' => '021-80625562',
            ],
            [
                'name' => 'PLN Wilayah Bengkulu',
                'address' => 'Suka Merindu, Kec. Sungai Serut, Kota Bengkulu, Bengkulu 38115',
                'batch' => 6,
                'quota' => 6,
                'contact_person' => null,
                'contact_phone' => '0736-123',
            ],
            [
                'name' => 'Alfasa Tech',
                'address' => null,
                'batch' => 7,
                'quota' => 4,
                'contact_person' => null,
                'contact_phone' => null,
            ],
            [
                'name' => 'Bank Indonesia (cabang Bengkulu)',
                'address' => 'Jl. A. Yani No.1, Kebun Keling, Kec. Tlk. Segara, Kota Bengkulu, Bengkulu 38116',
                'batch' => 8,
                'quota' => 4,
                'contact_person' => null,
                'contact_phone' => '0736-21735',
            ],
            [
                'name' => 'Ombudsman Bengkulu',
                'address' => 'Jalan Adam Malik KM 8 No.270, Kelurahan Jalan Gedang, Gading Cempaka, Kota Bengkulu, Bengkulu 38225',
                'batch' => 9,
                'quota' => 4,
                'contact_person' => 'Mustari Tasti',
                'contact_phone' => '08119723737',
            ],
            [
                'name' => 'Oase Technology',
                'address' => null,
                'batch' => 10,
                'quota' => 3,
                'contact_person' => null,
                'contact_phone' => null,
            ],
            [
                'name' => 'PT. Clarion',
                'address' => null,
                'batch' => 11,
                'quota' => 3,
                'contact_person' => null,
                'contact_phone' => null,
            ],
            [
                'name' => 'Preservence Technology',
                'address' => null,
                'batch' => 12,
                'quota' => 4,
                'contact_person' => null,
                'contact_phone' => null,
            ],
            [
                'name' => 'Akademik Unib Rektorat',
                'address' => 'Universitas Bengkulu, Kota Bengkulu, Bengkulu',
                'batch' => 13,
                'quota' => 2,
                'contact_person' => null,
                'contact_phone' => '0736-345805',
            ],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['name' => $company['name']],
                $company
            );
        }
    }
}
