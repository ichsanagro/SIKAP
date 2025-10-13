<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\KpApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS (aman di-run berulang)
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@simkp.test'], //buk endina
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'SUPERADMIN']
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@simkp.test'],
            ['name' => 'Admin Prodi', 'password' => Hash::make('password'), 'role' => 'ADMIN_PRODI'] //buk nis
        );

        $dosen = User::updateOrCreate(
            ['email' => 'dosen@simkp.test'],
            ['name' => 'Dosen Supervisor', 'password' => Hash::make('password'), 'role' => 'DOSEN_SUPERVISOR'] //dospem
        );

        $pengawas = User::updateOrCreate(
            ['email' => 'pengawas@simkp.test'],
            ['name' => 'Pengawas Lapangan', 'password' => Hash::make('password'), 'role' => 'PENGAWAS_LAPANGAN']
        );

        $mahasiswa1 = User::updateOrCreate(
            ['email' => 'mhs@simkp.test'],
            [
                'name' => 'Mahasiswa Satu',
                'password' => Hash::make('password'),
                'role' => 'MAHASISWA',
                'nim'  => 'G1F0230xxx',
                'prodi'=> 'Teknik Informatika'
            ]
        );

        $mahasiswa2 = User::updateOrCreate(
            ['email' => 'mhs2@simkp.test'],
            [
                'name' => 'Mahasiswa Dua',
                'password' => Hash::make('password'),
                'role' => 'MAHASISWA',
                'nim'  => 'G1F0230yyy',
                'prodi'=> 'Teknik Informatika'
            ]
        );

        $mahasiswa3 = User::updateOrCreate(
            ['email' => 'mhs3@simkp.test'],
            [
                'name' => 'Mahasiswa Tiga',
                'password' => Hash::make('password'),
                'role' => 'MAHASISWA',
                'nim'  => 'G1F0230zzz',
                'prodi'=> 'Teknik Informatika'
            ]
        );

        // COMPANIES (aman di-run berulang, kunci di 'name')
        $company1 = Company::updateOrCreate(
            ['name' => 'PT Bengkulu Tech'],
            ['address' => 'Jl. Raya Bengkulu No. 123, Bengkulu', 'batch' => 1, 'quota' => 10, 'contact_person' => 'Budi Santoso', 'contact_phone' => '081234567890']
        );

        $company2 = Company::updateOrCreate(
            ['name' => 'CV Inovasi Nusantara'],
            ['address' => 'Jl. Sudirman No. 45, Bengkulu', 'batch' => 2, 'quota' => 8, 'contact_person' => 'Siti Aminah', 'contact_phone' => '081987654321']
        );

        // SAMPLE KP APPLICATIONS
        KpApplication::updateOrCreate(
            ['student_id' => $mahasiswa1->id],
            [
                'title' => 'Pengembangan Sistem Informasi Manajemen Kepegawaian',
                'company_id' => $company1->id,
                'assigned_supervisor_id' => $dosen->id,
                'field_supervisor_id' => $pengawas->id,
                'start_date' => '2024-09-01',
                'end_date' => '2024-12-01',
                'status' => 'APPROVED',
                'description' => 'Pengembangan aplikasi web untuk manajemen data kepegawaian menggunakan Laravel dan MySQL.',
                'objectives' => '1. Membuat sistem CRUD untuk data karyawan\n2. Implementasi fitur reporting\n3. Testing dan deployment aplikasi',
                'verification_notes' => 'Aplikasi disetujui oleh Admin Prodi pada 15 Agustus 2024',
                'supervisor_period' => '2024-Ganjil'
            ]
        );

        KpApplication::updateOrCreate(
            ['student_id' => $mahasiswa2->id],
            [
                'title' => 'Implementasi Machine Learning untuk Analisis Data Penjualan',
                'company_id' => $company2->id,
                'assigned_supervisor_id' => $dosen->id,
                'field_supervisor_id' => $pengawas->id,
                'start_date' => '2024-09-15',
                'end_date' => '2024-12-15',
                'status' => 'ASSIGNED_SUPERVISOR',
                'description' => 'Penggunaan algoritma machine learning untuk menganalisis pola penjualan dan memberikan rekomendasi.',
                'objectives' => '1. Pengumpulan dan preprocessing data\n2. Training model ML\n3. Evaluasi dan deployment model',
                'verification_notes' => 'Proposal disetujui oleh Admin Prodi pada 20 Agustus 2024',
                'supervisor_period' => '2024-Ganjil'
            ]
        );

        KpApplication::updateOrCreate(
            ['student_id' => $mahasiswa3->id],
            [
                'title' => 'Pengembangan Mobile App E-Commerce',
                'company_id' => $company1->id,
                'assigned_supervisor_id' => $dosen->id,
                'start_date' => '2024-10-01',
                'end_date' => '2025-01-01',
                'status' => 'VERIFIED_PRODI',
                'description' => 'Pengembangan aplikasi mobile untuk platform e-commerce menggunakan React Native.',
                'objectives' => '1. Desain UI/UX aplikasi\n2. Implementasi fitur belanja online\n3. Integrasi payment gateway',
                'verification_notes' => 'Menunggu penugasan dosen pembimbing',
                'supervisor_period' => '2024-Ganjil'
            ]
        );
    }
}
