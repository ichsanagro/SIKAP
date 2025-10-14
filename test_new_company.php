<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing new company assignment...\n";

// Create a new company
$company = \App\Models\Company::create([
    'name' => 'Test Company New',
    'address' => 'Test Address',
    'phone' => '123456789',
    'email' => 'test@company.com',
]);

echo "Created new company with ID: {$company->id}\n";

// Assign field supervisor to this company
$fieldSupervisor = \App\Models\User::where('role', 'PENGAWAS_LAPANGAN')->first();
if ($fieldSupervisor) {
    $fieldSupervisor->supervisedCompanies()->attach($company->id);
    echo "Assigned field supervisor {$fieldSupervisor->name} to company {$company->name}\n";
} else {
    echo "No field supervisor found\n";
}

// Create a new KP application for this company
$student = \App\Models\User::where('role', 'MAHASISWA')->first();
if ($student) {
    $application = \App\Models\KpApplication::create([
        'student_id' => $student->id,
        'company_id' => $company->id,
        'title' => 'Test KP Application',
        'placement_option' => '3',
        'status' => 'DRAFT',
        'verification_status' => 'PENDING',
    ]);

    echo "Created KP application with ID: {$application->id}\n";

    // Test auto-assignment during approval
    $application->update([
        'verification_status' => 'APPROVED',
        'status' => 'APPROVED',
        'field_supervisor_id' => null, // Reset to test auto-assignment
    ]);

    // Simulate approval process
    $fieldSupervisorId = \App\Models\CompanyFieldSupervisor::where('company_id', $application->company_id)->value('field_supervisor_id');
    if ($fieldSupervisorId) {
        $application->update(['field_supervisor_id' => $fieldSupervisorId]);
        echo "Auto-assigned field supervisor ID {$fieldSupervisorId} to application {$application->id}\n";
    } else {
        echo "No field supervisor found for company {$company->id}\n";
    }
} else {
    echo "No student found\n";
}

echo "Test completed.\n";
