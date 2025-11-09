<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ExaminerSeminarScore;
use App\Models\KpApplication;
use App\Models\SeminarApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarExaminerScoreController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        // Get seminar applications where current user is examiner
        $seminarApplications = SeminarApplication::with(['student.kpApplications'])
            ->where('examiner_id', $user->id)
            ->where('status', 'APPROVED')
            ->get();

        // Extract KP applications from seminar applications
        $applications = $seminarApplications->pluck('student.kpApplications')->flatten()->unique('id');

        $selectedApp = null;
        if ($request->has('application')) {
            $selectedApp = KpApplication::with('student')
                ->where('id', $request->application)
                ->whereHas('student.seminarApplications', function($q) use ($user) {
                    $q->where('examiner_id', $user->id)->where('status', 'APPROVED');
                })
                ->first();
        }

        return view('supervisor.seminar.scores.create', compact('applications', 'selectedApp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kp_application_id' => 'required|exists:kp_applications,id',
            'laporan' => 'required|integer|min:0|max:100',
            'presentasi' => 'required|integer|min:0|max:100',
            'sikap' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $kpApplication = KpApplication::findOrFail($request->kp_application_id);

        // Ensure the current user is the examiner for this student's seminar
        $seminarApplication = SeminarApplication::where('student_id', $kpApplication->student_id)
            ->where('examiner_id', $user->id)
            ->where('status', 'APPROVED')
            ->first();

        if (!$seminarApplication) {
            abort(403, 'Anda bukan penguji untuk seminar mahasiswa ini.');
        }

        // Check if score already exists
        $existingScore = ExaminerSeminarScore::where('kp_application_id', $kpApplication->id)
            ->where('examiner_id', $user->id)
            ->first();

        if ($existingScore) {
            return back()->with('error', 'Nilai untuk seminar mahasiswa ini sudah ada.')->withInput();
        }

        // Calculate scores
        $totalSkor = $request->laporan + $request->presentasi + $request->sikap;
        $rataRata = round($totalSkor / 3, 2);
        $nilaiHuruf = $this->calculateGrade($rataRata);

        ExaminerSeminarScore::create([
            'kp_application_id' => $kpApplication->id,
            'examiner_id' => $user->id,
            'laporan' => $request->laporan,
            'presentasi' => $request->presentasi,
            'sikap' => $request->sikap,
            'catatan' => $request->catatan,
            'total_skor' => $totalSkor,
            'rata_rata' => $rataRata,
            'nilai_huruf' => $nilaiHuruf,
        ]);

        return redirect()->route('supervisor.seminar.index')
            ->with('success', 'Nilai seminar mahasiswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExaminerSeminarScore $examinerSeminarScore)
    {
        $this->authorizeScore($examinerSeminarScore);

        return view('supervisor.seminar.scores.edit', compact('examinerSeminarScore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExaminerSeminarScore $examinerSeminarScore)
    {
        $this->authorizeScore($examinerSeminarScore);

        $request->validate([
            'laporan' => 'required|integer|min:0|max:100',
            'presentasi' => 'required|integer|min:0|max:100',
            'sikap' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Calculate scores
        $totalSkor = $request->laporan + $request->presentasi + $request->sikap;
        $rataRata = round($totalSkor / 3, 2);
        $nilaiHuruf = $this->calculateGrade($rataRata);

        $examinerSeminarScore->update([
            'laporan' => $request->laporan,
            'presentasi' => $request->presentasi,
            'sikap' => $request->sikap,
            'catatan' => $request->catatan,
            'total_skor' => $totalSkor,
            'rata_rata' => $rataRata,
            'nilai_huruf' => $nilaiHuruf,
        ]);

        return redirect()->route('supervisor.seminar.index')
            ->with('success', 'Nilai seminar mahasiswa berhasil diperbarui.');
    }

    /**
     * Calculate grade based on average score
     */
    private function calculateGrade(float $score): string
    {
        if ($score >= 85) return 'A';
        if ($score >= 75) return 'B';
        if ($score >= 65) return 'C';
        if ($score >= 55) return 'D';
        return 'E';
    }

    /**
     * Authorize that current user can access this score
     */
    private function authorizeScore(ExaminerSeminarScore $score): void
    {
        $user = Auth::user();
        if ($score->examiner_id !== $user->id) {
            abort(403, 'Anda bukan penguji untuk nilai seminar ini.');
        }
    }
}
