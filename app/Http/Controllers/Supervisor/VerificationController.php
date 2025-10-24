<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Daftar pengajuan judul KP yang perlu diverifikasi oleh supervisor
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get students assigned to this supervisor
        $supervisedStudentIds = User::where('supervisor_id', $user->id)->pluck('id');

        // Get KP applications that are submitted and need verification
        $applications = KpApplication::with(['student', 'company'])
            ->whereIn('student_id', $supervisedStudentIds)
            ->where('status', 'SUBMITTED') // Status after student submits
            ->latest()
            ->paginate(20);

        return view('supervisor.verifications.index', compact('applications'));
    }

    /**
     * Show detail of a KP application for verification
     */
    public function show(KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        $kpApplication->load(['student', 'company']);

        return view('supervisor.verifications.show', compact('kpApplication'));
    }

    /**
     * Approve the KP application title
     */
    public function approve(Request $request, KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        if ($kpApplication->status !== 'SUBMITTED') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        // Set assigned_supervisor_id jika belum ada (berdasarkan supervisor_id mahasiswa)
        $updateData = [
            'status' => 'APPROVED', // Move to next status
            'notes' => $request->notes,
        ];

        if (!$kpApplication->assigned_supervisor_id && $kpApplication->student->supervisor_id) {
            $updateData['assigned_supervisor_id'] = $kpApplication->student->supervisor_id;
        }

        $kpApplication->update($updateData);

        // Auto-assign field supervisor if company is selected and no field supervisor assigned yet
        if ($kpApplication->company_id && !$kpApplication->field_supervisor_id) {
            $fieldSupervisorId = \App\Models\CompanyFieldSupervisor::where('company_id', $kpApplication->company_id)
                ->value('field_supervisor_id');

            if ($fieldSupervisorId) {
                $kpApplication->update(['field_supervisor_id' => $fieldSupervisorId]);
            }
        }

        return redirect()
            ->route('supervisor.verifications.show', $kpApplication)
            ->with('success', 'Judul KP telah disetujui.');
    }

    /**
     * Reject the KP application title
     */
    public function reject(Request $request, KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        if ($kpApplication->status !== 'SUBMITTED') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $request->validate([
            'notes' => 'required|string|max:2000',
        ]);

        $kpApplication->update([
            'status' => 'REJECTED',
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('supervisor.verifications.show', $kpApplication)
            ->with('success', 'Judul KP telah ditolak.');
    }

    /**
     * Authorize that the KP application belongs to a student supervised by this supervisor
     */
    private function authorizeSupervisor(KpApplication $kpApplication): void
    {
        $user = Auth::user();
        $supervisedStudentIds = User::where('supervisor_id', $user->id)->pluck('id');

        if (!in_array($kpApplication->student_id, $supervisedStudentIds->toArray())) {
            abort(403, 'Anda bukan pembimbing untuk mahasiswa ini.');
        }
    }
}
