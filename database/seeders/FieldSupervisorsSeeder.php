<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FieldSupervisorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fieldSupervisors = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Sari Dewi',
                'email' => 'sari.dewi@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Rizky Hadi',
                'email' => 'rizky.hadi@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Dewi Kusuma',
                'email' => 'dewi.kusuma@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@simkp.test',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($fieldSupervisors as $fs) {
            User::updateOrCreate(
                ['email' => $fs['email']],
                array_merge($fs, ['role' => 'PENGAWAS_LAPANGAN'])
            );
        }
    }
}
