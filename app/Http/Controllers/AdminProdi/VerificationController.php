<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use Illuminate\Http\Request;

class VerificationController extends Controller
{


    // Daftar pengajuan + filter status
    public function index(Request $request)
    {
        $status = $request->get('status');

        $apps = KpApplication::with(['student','company','verifier'])
            ->when($status, fn($q) => $q->where('verification_status', $status))
            ->latest()
            ->paginate(12);

        return view('admin_prodi.verification.index', compact('apps','status'));
    }

    // Detail 1 pengajuan
    public function show(KpApplication $application)
    {
        $application->load(['student','company','verifier']);
        return view('admin_prodi.verification.show', ['app' => $application]);
    }

    // ACC
    public function approve(Request $request, KpApplication $application)
    {
        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        // Get the student's assigned supervisor from users table
        $studentSupervisorId = $application->student->supervisor_id;

        // Auto-assign field supervisor based on company if the company has assigned field supervisors
        $fieldSupervisorId = null;
        if ($application->company_id) {
            $fieldSupervisorId = \App\Models\CompanyFieldSupervisor::where('company_id', $application->company_id)
                ->value('field_supervisor_id');
        }

        $application->update([
            'verification_status' => 'APPROVED',
            'verification_notes'  => $request->notes,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
            'assigned_supervisor_id' => $studentSupervisorId,
            'field_supervisor_id' => $fieldSupervisorId,
            'status'              => 'APPROVED',
        ]);

        return redirect()
            ->route('admin-prodi.verifications.show', $application)
            ->with('success', 'Pengajuan telah di-ACC.');
    }

    // Tolak
    public function reject(Request $request, KpApplication $application)
    {
        $request->validate([
            'notes' => 'required|string|max:2000',
        ]);

        $application->update([
            'verification_status' => 'REJECTED',
            'verification_notes'  => $request->notes,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
        ]);

        return redirect()
            ->route('admin-prodi.verifications.show', $application)
            ->with('success', 'Pengajuan telah ditolak.');
    }
}
