<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\KpApplication;

echo "Starting to update existing KP applications with field supervisors...\n";

$apps = KpApplication::where('status', 'APPROVED')->whereNotNull('company_id')->get();
$updated = 0;

foreach($apps as $app) {
    $fieldSupervisorId = KpApplication::where('company_id', $app->company_id)
        ->whereNotNull('field_supervisor_id')
        ->value('field_supervisor_id');

    if($fieldSupervisorId && !$app->field_supervisor_id) {
        $app->update(['field_supervisor_id' => $fieldSupervisorId]);
        echo "Updated application ID {$app->id} with field_supervisor_id {$fieldSupervisorId}\n";
        $updated++;
    }
}

echo "Done! Updated {$updated} applications.\n";
