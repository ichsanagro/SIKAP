<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\KpApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityLogController extends Controller
{
    /**
     * Daftar aktivitas milik MAHASISWA.
     * GET /activity-logs  (auth, role:MAHASISWA)
     */
    public function index()
    {
        $logs = ActivityLog::where('student_id', Auth::id())
            ->latest('date')
            ->paginate(10);

        return view('student.activity.index', compact('logs'));
    }

    /**
     * Form tambah aktivitas (MAHASISWA).
     * GET /activity-logs/create
     */
    public function create()
    {
        // KP yang sudah punya pengawas lapangan
        $myKps = Auth::user()->kpApplications()
            ->whereIn('status', ['ASSIGNED_SUPERVISOR','APPROVED','COMPLETED'])
            ->whereNotNull('field_supervisor_id')
            ->get(['id','title']);

        return view('student.activity.create', compact('myKps'));
    }

    /**
     * Simpan aktivitas (MAHASISWA).
     * POST /activity-logs
     */
    public function store(Request $request)
    {
        $request->validate([
            'kp_application_id' => 'required|exists:kp_applications,id',
            'date'              => 'required|date|before_or_equal:today',
            'description'       => 'required|string|max:3000',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
        ]);

        $kp = KpApplication::with('fieldSupervisor')
            ->findOrFail($request->kp_application_id);

        // Pastikan KP milik mahasiswa login
        if ($kp->student_id !== Auth::id()) {
            abort(403, 'KP ini bukan milik Anda.');
        }

        // Pastikan sudah ada pengawas lapangan
        if (!$kp->field_supervisor_id) {
            return back()->with('error', 'Pengawas lapangan belum ditetapkan.')->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('activity_photos', 'public');
        }

        ActivityLog::create([
            'kp_application_id' => $kp->id,
            'student_id'        => Auth::id(),
            'date'              => $request->date,
            'description'       => $request->description,
            'photo_path'        => $photoPath,
            'status'            => 'PENDING',
        ]);

        return redirect()->route('activity-logs.index')
            ->with('success', 'Aktivitas disimpan dan menunggu persetujuan pengawas.');
    }

    /**
     * Daftar aktivitas untuk PENGAWAS LAPANGAN.
     * GET /lapangan/activities (auth, role:PENGAWAS_LAPANGAN,SUPERADMIN)
     */
    public function reviewList()
    {
        $user = Auth::user();

        $query = ActivityLog::with(['kpApplication.student']);

        // Pengawas hanya melihat miliknya; superadmin bisa lihat semua
        if ($user->role === 'PENGAWAS_LAPANGAN') {
            $query->whereHas('kpApplication', function ($q) use ($user) {
                $q->where('field_supervisor_id', $user->id);
            });
        }

        $logs = $query->whereIn('status', ['PENDING','REVISION'])
            ->latest('date')
            ->paginate(20);

        return view('field.activities.index', compact('logs'));
    }

    /**
     * Approve aktivitas (PENGAWAS LAPANGAN).
     * POST /lapangan/activities/{log}/approve
     * POST /field-supervisor/students/{application}/activities/{activityLog}/approve
     */
    public function approve(ActivityLog $activityLog)
    {
        $this->authorizeFieldSupervisor($activityLog);

        if ($activityLog->status === 'APPROVED') {
            return back()->with('success', 'Aktivitas sudah disetujui sebelumnya.');
        }

        $activityLog->update(['status' => 'APPROVED']);

        return back()->with('success', 'Aktivitas disetujui.');
    }

    /**
     * Minta revisi (PENGAWAS LAPANGAN).
     * POST /lapangan/activities/{log}/revise
     * POST /field-supervisor/students/{application}/activities/{activityLog}/revise
     */
    public function revise(ActivityLog $activityLog)
    {
        $this->authorizeFieldSupervisor($activityLog);

        $activityLog->update(['status' => 'REVISION']);

        return back()->with('success', 'Aktivitas diminta revisi.');
    }

    /**
     * (Opsional) Unduh foto aktivitas:
     * GET /activity-logs/{log}/photo
     */
    public function downloadPhoto(ActivityLog $log)
    {
        $user = Auth::user();

        $isOwner       = $log->student_id === $user->id;
        $isFieldSup    = $log->kpApplication?->field_supervisor_id === $user->id;
        $isSuperAdmin  = $user->role === 'SUPERADMIN';

        if (!$isOwner && !$isFieldSup && !$isSuperAdmin) {
            abort(403);
        }

        if (!$log->photo_path || !Storage::disk('public')->exists($log->photo_path)) {
            abort(404, 'Foto tidak ditemukan.');
        }

        return Storage::disk('public')->download($log->photo_path);
    }

    /**
     * Hanya pengawas terkait (atau superadmin) yang boleh approve/revise.
     */
    private function authorizeFieldSupervisor(ActivityLog $log): void
    {
        $user = Auth::user();

        $fieldSupervisorId = $log->kpApplication?->field_supervisor_id;

        $allowed = $user->role === 'SUPERADMIN' || ($fieldSupervisorId && $fieldSupervisorId === $user->id);

        if (!$allowed) {
            abort(403, 'Anda bukan pengawas lapangan untuk aktivitas ini.');
        }
    }
}
