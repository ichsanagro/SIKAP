<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing field supervisor assignment...\n";

$application = \App\Models\KpApplication::where('company_id', 1)->whereNull('field_supervisor_id')->first();

if ($application) {
    echo 'Found application without field supervisor: ' . $application->id . "\n";
    $fieldSupervisorId = \App\Models\CompanyFieldSupervisor::where('company_id', $application->company_id)->value('field_supervisor_id');
    echo 'Field supervisor ID from new table: ' . ($fieldSupervisorId ?? 'null') . "\n";
} else {
    echo "No applications found without field supervisor for company 1\n";
}

echo "Test completed.\n";
