<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\Company;

class AdminProdiController extends Controller
{
    public function dashboard()
    {
        // Statistics relevant to Admin Prodi
        $stats = [
            'applications' => KpApplication::count(),
            'pending_verifications' => KpApplication::where('verification_status', 'PENDING')->count(),
            'approved_applications' => KpApplication::where('verification_status', 'APPROVED')->count(),
            'rejected_applications' => KpApplication::where('verification_status', 'REJECTED')->count(),
            'companies' => Company::count(),
            'assigned_supervisors' => KpApplication::whereNotNull('assigned_supervisor_id')->count(),
            'assigned_field_supervisors' => KpApplication::whereNotNull('field_supervisor_id')->count(),
        ];

        return view('admin_prodi.index', compact('stats'));
    }
}
