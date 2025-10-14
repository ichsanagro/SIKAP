<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "Starting migration of field supervisor assignments...\n";

$fieldSupervisors = User::where('role', 'PENGAWAS_LAPANGAN')->get();

foreach ($fieldSupervisors as $user) {
    $companyIds = \App\Models\KpApplication::where('field_supervisor_id', $user->id)
        ->whereNotNull('company_id')
        ->distinct()
        ->pluck('company_id')
        ->toArray();

    if (!empty($companyIds)) {
        $user->supervisedCompanies()->sync($companyIds);
        echo "Migrated user {$user->name}: " . implode(', ', $companyIds) . "\n";
    } else {
        echo "No companies found for user {$user->name}\n";
    }
}

echo "Migration completed.\n";
