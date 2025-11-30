<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $applications = KpApplication::with(['student', 'supervisor', 'fieldSupervisor'])
            ->where('status', 'APPROVED')
            ->paginate(10);

        $supervisors = User::where('role', 'DOSEN_SUPERVISOR')->get();
        $fieldSupervisors = User::where('role', 'PENGAWAS_LAPANGAN')->get();

        return view('admin_prodi.assignments.index', compact('applications', 'supervisors', 'fieldSupervisors'));
    }

    public function assignSupervisor(Request $request, KpApplication $kp)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        $kp->update([
            'supervisor_id' => $request->supervisor_id,
        ]);

        return redirect()->back()->with('success', 'Supervisor berhasil ditugaskan.');
    }

    public function assignFieldSupervisor(Request $request, KpApplication $kp)
    {
        $request->validate([
            'field_supervisor_id' => 'required|exists:users,id',
        ]);

        $kp->update([
            'field_supervisor_id' => $request->field_supervisor_id,
        ]);

        return redirect()->back()->with('success', 'Pengawas lapangan berhasil ditugaskan.');
    }
}
