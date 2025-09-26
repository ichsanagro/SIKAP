<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS (aman di-run berulang)
        User::updateOrCreate(
            ['email' => 'superadmin@simkp.test'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'SUPERADMIN']
        );

        User::updateOrCreate(
            ['email' => 'admin@simkp.test'],
            ['name' => 'Admin Prodi', 'password' => Hash::make('password'), 'role' => 'ADMIN_PRODI']
        );

        User::updateOrCreate(
            ['email' => 'dosen@simkp.test'],
            ['name' => 'Dosen Supervisor', 'password' => Hash::make('password'), 'role' => 'DOSEN_SUPERVISOR']
        );

        User::updateOrCreate(
            ['email' => 'pengawas@simkp.test'],
            ['name' => 'Pengawas Lapangan', 'password' => Hash::make('password'), 'role' => 'PENGAWAS_LAPANGAN']
        );

        User::updateOrCreate(
            ['email' => 'mhs@simkp.test'],
            [
                'name' => 'Mahasiswa Satu',
                'password' => Hash::make('password'),
                'role' => 'MAHASISWA',
                'nim'  => 'G1F0230xxx',
                'prodi'=> 'Teknik Informatika'
            ]
        );

        // COMPANIES (aman di-run berulang, kunci di 'name')
        Company::updateOrCreate(
            ['name' => 'PT Bengkulu Tech'],
            ['address' => 'Bengkulu', 'batch' => 1, 'quota' => 10, 'contact_person' => null, 'contact_phone' => null]
        );

        Company::updateOrCreate(
            ['name' => 'CV Inovasi Nusantara'],
            ['address' => 'Bengkulu', 'batch' => 2, 'quota' => 8, 'contact_person' => null, 'contact_phone' => null]
        );
    }
}
