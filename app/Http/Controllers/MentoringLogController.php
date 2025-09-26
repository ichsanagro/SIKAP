<?php

namespace App\Http\Controllers;

use App\Models\MentoringLog;
use App\Models\KpApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MentoringLogController extends Controller
{
    /**
     * Halaman daftar bimbingan untuk MAHASISWA.
     * Route: GET /mentoring-logs  (middleware: auth, role:MAHASISWA)
     */
    public function index()
    {
        $logs = MentoringLog::with(['kpApplication'])
            ->where('student_id', Auth::id())
            ->latest('date')
            ->paginate(10);

        return view('student.mentoring.index', compact('logs'));
    }

    /**
     * Form tambah bimbingan untuk MAHASISWA.
     * Route: GET /mentoring-logs/create
     */
    public function create()
    {
        // Hanya KP yang sudah punya pembimbing & aktif
        $myKps = Auth::user()->kpApplications()
            ->whereIn('status', ['ASSIGNED_SUPERVISOR','APPROVED','COMPLETED'])
            ->whereNotNull('assigned_supervisor_id')
            ->get(['id','title','assigned_supervisor_id']);

        return view('student.mentoring.create', compact('myKps'));
    }

    /**
     * Simpan bimbingan (MAHASISWA).
     * Route: POST /mentoring-logs
     */
    public function store(Request $request)
    {
        $request->validate([
            'kp_application_id' => 'required|exists:kp_applications,id',
            'date'              => 'required|date|before_or_equal:today',
            'topic'             => 'required|string|max:1000',
            'notes'             => 'nullable|string|max:5000',
            'attachment'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ]);

        $kp = KpApplication::with('supervisor')
            ->where('id', $request->kp_application_id)
            ->firstOrFail();

        // Pastikan KP milik mahasiswa login
        if ($kp->student_id !== Auth::id()) {
            abort(403, 'KP ini bukan milik Anda.');
        }

        // Pastikan sudah ada dosen pembimbing
        if (!$kp->assigned_supervisor_id) {
            return back()->with('error', 'Dosen pembimbing belum ditetapkan.')->withInput();
        }

        // Simpan berkas (opsional)
        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('mentoring_attachments', 'public');
        }

        MentoringLog::create([
            'kp_application_id' => $kp->id,
            'student_id'        => Auth::id(),
            'supervisor_id'     => $kp->assigned_supervisor_id,
            'date'              => $request->date,
            'topic'             => $request->topic,
            'notes'             => $request->notes,
            'attachment_path'   => $path,
            'status'            => 'PENDING',
        ]);

        return redirect()->route('mentoring-logs.index')
            ->with('success', 'Catatan bimbingan disimpan dan menunggu persetujuan pembimbing.');
    }

    /**
     * Daftar bimbingan untuk DOSEN SUPERVISOR.
     * Route: GET /supervisor/mentoring
     * Middleware: auth, role:DOSEN_SUPERVISOR,SUPERADMIN
     */
    public function reviewList()
    {
        $user = Auth::user();

        $logs = MentoringLog::with(['kpApplication.student'])
            ->where(function ($q) use ($user) {
                // Jika supervisor: hanya yang dibimbingnya
                if ($user->role === 'DOSEN_SUPERVISOR') {
                    $q->where('supervisor_id', $user->id);
                }
            })
            ->whereIn('status', ['PENDING','REVISION'])
            ->latest('date')
            ->paginate(20);

        // NOTE: sediakan view supervisor.mentoring.index
        return view('supervisor.mentoring.index', compact('logs'));
    }

    /**
     * Approve bimbingan (DOSEN SUPERVISOR).
     * Route: POST /supervisor/mentoring/{log}/approve
     */
    public function approve(MentoringLog $log)
    {
        $this->authorizeSupervisor($log);

        if ($log->status === 'APPROVED') {
            return back()->with('success', 'Log sudah disetujui sebelumnya.');
        }

        $log->update(['status' => 'APPROVED']);

        return back()->with('success', 'Bimbingan disetujui.');
    }

    /**
     * Mark as REVISION (DOSEN SUPERVISOR).
     * Route: POST /supervisor/mentoring/{log}/revise
     */
    public function revise(MentoringLog $log, Request $request)
    {
        $this->authorizeSupervisor($log);

        // Opsional: jika ingin menyimpan catatan revisi, dapat tambah kolom baru.
        // Untuk sekarang, kita hanya ubah status.
        $log->update(['status' => 'REVISION']);

        return back()->with('success', 'Bimbingan diminta revisi.');
    }

    /**
     * (Opsional) Download lampiran - hanya pemilik / supervisor / superadmin.
     */
    public function downloadAttachment(MentoringLog $log)
    {
        $user = Auth::user();
        $isOwner     = $log->student_id === $user->id;
        $isSupervisor= $log->supervisor_id === $user->id;
        $isSuperAdmin= $user->role === 'SUPERADMIN';

        if (!$isOwner && !$isSupervisor && !$isSuperAdmin) {
            abort(403);
        }

        if (!$log->attachment_path || !Storage::disk('public')->exists($log->attachment_path)) {
            abort(404, 'Lampiran tidak ditemukan.');
        }

        return Storage::disk('public')->download($log->attachment_path);
    }

    /**
     * Guard khusus supervisor — hanya supervisor terkait (atau superadmin) yang boleh approve/revise.
     */
    private function authorizeSupervisor(MentoringLog $log): void
    {
        $user = Auth::user();
        $allowed = $user->role === 'SUPERADMIN' || $log->supervisor_id === $user->id;
        if (!$allowed) {
            abort(403, 'Anda bukan pembimbing untuk bimbingan ini.');
        }
    }
}
