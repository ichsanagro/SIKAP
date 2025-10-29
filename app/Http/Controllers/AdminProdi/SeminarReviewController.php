<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\SeminarApplication;
use App\Models\User;
use Illuminate\Http\Request;

class SeminarReviewController extends Controller
{
    public function index()
    {
        $applications = SeminarApplication::with('student')
            ->latest()
            ->paginate(15);

        $examiners = User::where('role', 'DOSEN_SUPERVISOR')->get();

        return view('admin_prodi.seminar.index', compact('applications', 'examiners'));
    }

    public function approve(Request $request, SeminarApplication $application)
    {
        $request->validate([
            'examiner_id' => 'required|exists:users,id',
        ]);

        $application->update([
            'status' => 'APPROVED',
            'examiner_id' => $request->examiner_id,
        ]);

        return redirect()->route('admin-prodi.seminar.index')
            ->with('success', 'Pengajuan seminar disetujui.');
    }

    public function reject(Request $request, SeminarApplication $application)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $application->update([
            'status' => 'REJECTED',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin-prodi.seminar.index')
            ->with('success', 'Pengajuan seminar ditolak.');
    }
}
