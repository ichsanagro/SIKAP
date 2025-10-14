<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\KpApplication;
use App\Models\Company;

echo "=== FIELD SUPERVISORS ===\n";
$fieldSupervisors = User::where('role', 'PENGAWAS_LAPANGAN')->get();
foreach($fieldSupervisors as $fs) {
    $supervisedCount = KpApplication::where('field_supervisor_id', $fs->id)->count();
    echo $fs->name . ' (ID: ' . $fs->id . ') - Supervised Apps: ' . $supervisedCount . "\n";
}

echo "\n=== COMPANIES WITH SUPERVISORS ===\n";
$companies = Company::with('kpApplications')->get();
foreach($companies as $company) {
    $supervisorApps = $company->kpApplications->whereNotNull('field_supervisor_id');
    if($supervisorApps->count() > 0) {
        $supervisorId = $supervisorApps->first()->field_supervisor_id;
        $supervisor = User::find($supervisorId);
        echo $company->name . ' -> ' . ($supervisor ? $supervisor->name : 'Unknown') . ' (' . $supervisorApps->count() . ' apps)' . "\n";
    }
}

echo "\n=== APPROVED APPLICATIONS ===\n";
$approvedApps = KpApplication::where('status', 'APPROVED')->with(['student', 'company'])->get();
foreach($approvedApps as $app) {
    echo 'App ID: ' . $app->id . ', Student: ' . ($app->student->name ?? 'N/A') . ', Company: ' . ($app->company->name ?? 'N/A') . ', Field Supervisor ID: ' . ($app->field_supervisor_id ?? 'NULL') . "\n";
}
