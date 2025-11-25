<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosens = [
            [
                'name' => 'Dr. Endina Putri Purwandari, S.T., M.Kom.',
                'email' => 'endina@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Aan Erlanshari, S.T., M.Eng.',
                'email' => 'aan@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Andang Wijanarko, M.Kom.',
                'email' => 'andang@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ferzha Putra Utama, S.T., M.Eng.',
                'email' => 'ferha@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Kurnia Anggriani, S.T., M.T., Ph.D.',
                'email' => 'kurnia@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Julia Purnama Sari, S.T., M.Kom.',
                'email' => 'julia@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Niska Ramadhani, M.Kom.',
                'email' => 'niska@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Nurul Renaningtias, S.T., M.Kom.',
                'email' => 'nurul@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Soni Ayi Purnama, M.Kom.',
                'email' => 'soni@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Tiara Eka Putri, S.T., M.Kom.',
                'email' => 'tiara@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Willi Novrian, M.Kom.',
                'email' => 'willi@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Yudi Setiawan, S.T., M.Eng.',
                'email' => 'yudi@simkp.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Yusran Panca Putra, M.Kom.',
                'email' => 'yusran@simkp.test',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($dosens as $dosen) {
            User::updateOrCreate(
                ['email' => $dosen['email']],
                array_merge($dosen, ['role' => 'DOSEN_SUPERVISOR'])
            );
        }
    }
}
