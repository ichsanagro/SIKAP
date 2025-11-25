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
        // Call individual seeders
        $this->call([
            CompaniesSeeder::class,
            FieldSupervisorsSeeder::class,
            DosenSeeder::class,
        ]);
    }
}
