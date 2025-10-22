<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KpApplication;
use App\Models\MentoringLog;
use App\Models\KpScore;
use App\Models\Report;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    /**
     * Dashboard untuk Dosen Supervisor
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get students assigned to this supervisor via user.supervisor_id relationship
        $supervisedStudents = User::where('supervisor_id', $user->id)->pluck('id');

        $stats = [
            'total_students' => $supervisedStudents->count(),
            'pending_mentoring' => MentoringLog::where('supervisor_id', $user->id)
                ->whereIn('status', ['PENDING', 'REVISION'])->count(),
            'approved_mentoring' => MentoringLog::where('supervisor_id', $user->id)
                ->where('status', 'APPROVED')->count(),
            'total_scores' => KpScore::where('supervisor_id', $user->id)->count(),
            'pending_verifications' => KpApplication::whereIn('student_id', $supervisedStudents)
                ->where('status', 'SUBMITTED')
                ->count(),
        ];

        // Get recent supervised students for display
        $students = User::where('supervisor_id', $user->id)
            ->whereHas('kpApplications', function($q) {
                $q->where('verification_status', 'APPROVED');
            })
            ->with(['kpApplications.company'])
            ->take(5)
            ->get();

        return view('supervisor.dashboard', compact('stats', 'students'));
    }

    /**
     * Daftar mahasiswa bimbingan - hanya aksi "lihat"
     */
    public function students()
    {
        $user = Auth::user();

        // Get students assigned via supervisor_id relationship (same as dashboard)
        $students = User::where('supervisor_id', $user->id)
            ->with(['kpApplications.company', 'kpApplications.mentoringLogs' => function($query) {
                $query->latest('date')->take(3); // Get latest 3 mentoring logs for each KP
            }])
            ->paginate(20);

        // Check if there are any students assigned to this supervisor
        $hasStudents = $students->isNotEmpty();

        return view('supervisor.students.index', compact('students', 'hasStudents'));
    }

    /**
     * Lihat detail mahasiswa bimbingan
     */
    public function showStudent(KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        $kpApplication->load(['student', 'company', 'mentoringLogs', 'reports', 'scores']);

        return view('supervisor.students.show', compact('kpApplication'));
    }

    /**
     * Daftar catatan bimbingan - aksi: lihat, tambah, hapus, ubah
     */
    public function mentoringLogs()
    {
        $user = Auth::user();

        $logs = MentoringLog::with(['kpApplication.student'])
            ->where('supervisor_id', $user->id)
            ->latest('date')
            ->paginate(20);

        return view('supervisor.mentoring.index', compact('logs'));
    }

    /**
     * Lihat detail catatan bimbingan
     */
    public function showMentoringLog(MentoringLog $mentoringLog)
    {
        $this->authorizeMentoringLog($mentoringLog);

        return view('supervisor.mentoring.show', compact('mentoringLog'));
    }

    /**
     * Form tambah catatan bimbingan
     */
    public function createMentoringLog()
    {
        $user = Auth::user();

        // Get KP applications assigned to this supervisor
        $applications = KpApplication::with('student')
            ->where('assigned_supervisor_id', $user->id)
            ->where('verification_status', 'APPROVED')
            ->whereIn('status', ['ASSIGNED_SUPERVISOR', 'APPROVED', 'COMPLETED'])
            ->get();

        return view('supervisor.mentoring.create', compact('applications'));
    }

    /**
     * Simpan catatan bimbingan baru
     */
    public function storeMentoringLog(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'kp_application_id' => 'required|exists:kp_applications,id',
            'date' => 'required|date|before_or_equal:today',
            'topic' => 'required|string|max:1000',
            'student_notes' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = Auth::user();
        $kpApplication = KpApplication::findOrFail($request->kp_application_id);

        // Pastikan KP milik supervisor ini
        if ($kpApplication->assigned_supervisor_id !== $user->id) {
            abort(403, 'Anda bukan pembimbing untuk KP ini.');
        }

        // Pastikan student_id sesuai dengan KP
        if ($kpApplication->student_id !== (int)$request->student_id) {
            abort(403, 'Student ID tidak sesuai dengan KP yang dipilih.');
        }

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('mentoring_attachments', 'public');
        }

        MentoringLog::create([
            'kp_application_id' => $kpApplication->id,
            'student_id' => $kpApplication->student_id,
            'supervisor_id' => $user->id,
            'date' => $request->date,
            'topic' => $request->topic,
            'student_notes' => $request->student_notes,
            'notes' => $request->notes,
            'attachment_path' => $path,
            'status' => 'APPROVED', // Supervisor langsung approve log yang dibuatnya
        ]);

        return redirect()->route('supervisor.mentoring.index')
            ->with('success', 'Catatan bimbingan berhasil ditambahkan.');
    }

    /**
     * Form edit catatan bimbingan
     */
    public function editMentoringLog(MentoringLog $mentoringLog)
    {
        $this->authorizeMentoringLog($mentoringLog);

        return view('supervisor.mentoring.edit', compact('mentoringLog'));
    }

    /**
     * Update catatan bimbingan
     */
    public function updateMentoringLog(Request $request, MentoringLog $mentoringLog)
    {
        $this->authorize('update', $mentoringLog);

        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'topic' => 'required|string|max:1000',
            'student_notes' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:5000',
            'status' => 'required|in:PENDING,APPROVED,REVISION',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $updateData = [
            'date' => $request->date,
            'topic' => $request->topic,
            'student_notes' => $request->student_notes,
            'notes' => $request->notes,
            'status' => $request->status,
        ];

        // Jangan ubah field student_id dan supervisor_id
        // Hanya update status, notes, date, topic, dan attachment

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('mentoring_attachments', 'public');
            $updateData['attachment_path'] = $path;
        }

        $mentoringLog->update($updateData);

        return redirect()->route('supervisor.mentoring.index')
            ->with('success', 'Catatan bimbingan berhasil diperbarui.');
    }

    /**
     * Hapus catatan bimbingan
     */
    public function destroyMentoringLog(MentoringLog $mentoringLog)
    {
        $this->authorizeMentoringLog($mentoringLog);

        $mentoringLog->delete();

        return redirect()->route('supervisor.mentoring.index')
            ->with('success', 'Catatan bimbingan berhasil dihapus.');
    }

    /**
     * Daftar nilai mahasiswa - aksi: tambah, ubah
     */
    public function scores()
    {
        $user = Auth::user();

        $scores = KpScore::with(['application.student'])
            ->where('supervisor_id', $user->id)
            ->paginate(20);

        return view('supervisor.scores.index', compact('scores'));
    }

    /**
     * Form tambah nilai mahasiswa
     */
    public function createScore()
    {
        $user = Auth::user();

        // Get students assigned via supervisor_id relationship
        $supervisedStudentIds = User::where('supervisor_id', $user->id)->pluck('id');

        $applications = KpApplication::with('student')
            ->whereIn('student_id', $supervisedStudentIds)
            ->where('verification_status', 'APPROVED')
            ->where('status', 'COMPLETED')
            ->get();

        return view('supervisor.scores.create', compact('applications'));
    }

    /**
     * Simpan nilai mahasiswa
     */
    public function storeScore(Request $request)
    {
        $request->validate([
            'kp_application_id' => 'required|exists:kp_applications,id',
            'score' => 'required|numeric|min:0|max:100',
            'grade' => 'required|in:A,B,C,D,E',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $kpApplication = KpApplication::findOrFail($request->kp_application_id);

        // Pastikan KP milik supervisor ini dan sudah completed
        if ($kpApplication->assigned_supervisor_id !== $user->id) {
            abort(403, 'Anda bukan pembimbing untuk KP ini.');
        }

        if ($kpApplication->status !== 'COMPLETED') {
            return back()->with('error', 'KP belum selesai.')->withInput();
        }

        // Cek apakah sudah ada nilai
        $existingScore = KpScore::where('kp_application_id', $kpApplication->id)->first();
        if ($existingScore) {
            return back()->with('error', 'Nilai untuk KP ini sudah ada.')->withInput();
        }

        KpScore::create([
            'kp_application_id' => $kpApplication->id,
            'supervisor_id' => $user->id,
            'score' => $request->score,
            'grade' => $request->grade,
            'notes' => $request->notes,
        ]);

        return redirect()->route('supervisor.scores.index')
            ->with('success', 'Nilai mahasiswa berhasil ditambahkan.');
    }

    /**
     * Form edit nilai mahasiswa
     */
    public function editScore(KpScore $kpScore)
    {
        $this->authorizeScore($kpScore);

        return view('supervisor.scores.edit', compact('kpScore'));
    }

    /**
     * Update nilai mahasiswa
     */
    public function updateScore(Request $request, KpScore $kpScore)
    {
        $this->authorizeScore($kpScore);

        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'grade' => 'required|in:A,B,C,D,E',
            'notes' => 'nullable|string|max:1000',
        ]);

        $kpScore->update([
            'score' => $request->score,
            'grade' => $request->grade,
            'notes' => $request->notes,
        ]);

        return redirect()->route('supervisor.scores.index')
            ->with('success', 'Nilai mahasiswa berhasil diperbarui.');
    }

    /**
     * Daftar dokumen mahasiswa - aksi: lihat (dengan approve/reject)
     */
    public function documents()
    {
        $user = Auth::user();

        // Get students assigned via supervisor_id relationship
        $supervisedStudentIds = User::where('supervisor_id', $user->id)->pluck('id');

        $applications = KpApplication::with(['student', 'reports', 'questionnaires'])
            ->whereIn('student_id', $supervisedStudentIds)
            ->where('verification_status', 'APPROVED')
            ->whereIn('status', ['APPROVED', 'COMPLETED'])
            ->paginate(20);

        return view('supervisor.documents.index', compact('applications'));
    }

    /**
     * Lihat dokumen mahasiswa dengan opsi approve/reject
     */
    public function showDocument(KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        $kpApplication->load(['student', 'reports', 'questionnaires']);

        return view('supervisor.documents.show', compact('kpApplication'));
    }

    /**
     * Approve dokumen laporan
     */
    public function approveReport(Report $report)
    {
        $this->authorizeReport($report);

        $report->update(['status' => 'APPROVED']);

        return back()->with('success', 'Laporan berhasil disetujui.');
    }

    /**
     * Reject dokumen laporan
     */
    public function rejectReport(Request $request, Report $report)
    {
        $this->authorizeReport($report);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $report->update([
            'status' => 'REJECTED',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Laporan ditolak dengan alasan: ' . $request->rejection_reason);
    }

    /**
     * Approve kuesioner instansi mitra
     */
    public function approveQuestionnaire(Questionnaire $questionnaire)
    {
        $this->authorizeQuestionnaire($questionnaire);

        $questionnaire->update(['status' => 'APPROVED']);

        return back()->with('success', 'Kuesioner berhasil disetujui.');
    }

    /**
     * Reject kuesioner instansi mitra
     */
    public function rejectQuestionnaire(Request $request, Questionnaire $questionnaire)
    {
        $this->authorizeQuestionnaire($questionnaire);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $questionnaire->update([
            'status' => 'REJECTED',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Kuesioner ditolak dengan alasan: ' . $request->rejection_reason);
    }

    /**
     * Daftar kuesioner instansi mitra - aksi: isi (create)
     */
    public function questionnaires()
    {
        $user = Auth::user();

        $questionnaires = Questionnaire::with(['kpApplication.company'])
            ->whereHas('kpApplication', function($q) use ($user) {
                $q->where('assigned_supervisor_id', $user->id);
            })
            ->paginate(20);

        return view('supervisor.questionnaires.index', compact('questionnaires'));
    }

    /**
     * Form isi kuesioner instansi mitra
     */
    public function createQuestionnaire(KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        // Pastikan KP sudah completed dan belum ada kuesioner
        if ($kpApplication->status !== 'COMPLETED') {
            return back()->with('error', 'KP belum selesai.');
        }

        $existingQuestionnaire = Questionnaire::where('kp_application_id', $kpApplication->id)->first();
        if ($existingQuestionnaire) {
            return back()->with('error', 'Kuesioner untuk KP ini sudah ada.');
        }

        return view('supervisor.questionnaires.create', compact('kpApplication'));
    }

    /**
     * Simpan kuesioner instansi mitra
     */
    public function storeQuestionnaire(Request $request, KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        $request->validate([
            'company_rating' => 'required|integer|min:1|max:5',
            'supervisor_rating' => 'required|integer|min:1|max:5',
            'facilities_rating' => 'required|integer|min:1|max:5',
            'overall_experience' => 'required|string|max:1000',
            'suggestions' => 'nullable|string|max:1000',
        ]);

        Questionnaire::create([
            'kp_application_id' => $kpApplication->id,
            'company_rating' => $request->company_rating,
            'supervisor_rating' => $request->supervisor_rating,
            'facilities_rating' => $request->facilities_rating,
            'overall_experience' => $request->overall_experience,
            'suggestions' => $request->suggestions,
            'status' => 'PENDING',
        ]);

        return redirect()->route('supervisor.questionnaires.index')
            ->with('success', 'Kuesioner berhasil disimpan.');
    }

    // Authorization helpers
    private function authorizeSupervisor(KpApplication $kpApplication): void
    {
        $user = Auth::user();
        if ($kpApplication->assigned_supervisor_id !== $user->id && $user->role !== 'SUPERADMIN') {
            abort(403, 'Anda bukan pembimbing untuk KP ini.');
        }
    }

    private function authorizeMentoringLog(MentoringLog $mentoringLog): void
    {
        $user = Auth::user();
        if ($mentoringLog->supervisor_id !== $user->id && $user->role !== 'SUPERADMIN') {
            abort(403, 'Anda bukan pembimbing untuk catatan bimbingan ini.');
        }
    }

    private function authorizeScore(KpScore $kpScore): void
    {
        $user = Auth::user();
        if ($kpScore->supervisor_id !== $user->id && $user->role !== 'SUPERADMIN') {
            abort(403, 'Anda bukan pembimbing untuk nilai ini.');
        }
    }

    private function authorizeReport(Report $report): void
    {
        $user = Auth::user();
        $kpApplication = $report->kpApplication;
        if ($kpApplication->assigned_supervisor_id !== $user->id && $user->role !== 'SUPERADMIN') {
            abort(403, 'Anda bukan pembimbing untuk laporan ini.');
        }
    }

    private function authorizeQuestionnaire(Questionnaire $questionnaire): void
    {
        $user = Auth::user();
        $kpApplication = $questionnaire->kpApplication;
        if ($kpApplication->assigned_supervisor_id !== $user->id && $user->role !== 'SUPERADMIN') {
            abort(403, 'Anda bukan pembimbing untuk kuesioner ini.');
        }
    }
}
