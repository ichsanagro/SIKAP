<?php

namespace App\Http\Controllers\FieldSupervisor;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;

class StudentController extends Controller
{
    public function index() {
        $apps = KpApplication::with(['student','company'])
            ->where('field_supervisor_id', auth()->id())
            ->latest()->paginate(15);
        return view('field_supervisor.students.index', compact('apps'));
    }

    public function dashboard() {
        // Statistics
        $stats = [
            'students' => KpApplication::where('field_supervisor_id', auth()->id())->count(),
            'scores' => \App\Models\KpScore::whereHas('application', function($q) {
                $q->where('field_supervisor_id', auth()->id());
            })->count(),
            'evaluations' => \App\Models\FieldEvaluation::where('supervisor_id', auth()->id())->count(),
            'quotas' => \App\Models\CompanyQuota::whereIn('company_id',
                KpApplication::where('field_supervisor_id', auth()->id())
                    ->whereNotNull('company_id')
                    ->distinct()
                    ->pluck('company_id')
            )->count(),
        ];

        // Recent data
        $recentScores = \App\Models\KpScore::with(['application.student', 'application.company'])
            ->whereHas('application', function($q) {
                $q->where('field_supervisor_id', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        $recentEvaluations = \App\Models\FieldEvaluation::with(['application.student', 'application.company'])
            ->where('supervisor_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('field_supervisor.dashboard', compact('stats', 'recentScores', 'recentEvaluations'));
    }

    public function show(KpApplication $application) {
        $this->authorizeApp($application);

        // Fetch activity logs for this student
        $activityLogs = \App\Models\ActivityLog::where('kp_application_id', $application->id)
            ->with('student')
            ->latest('date')
            ->get();

        return view('field_supervisor.students.show', compact('application', 'activityLogs'));
    }

    // Hapus = unassign dari pengawas lapangan ini
    public function destroy(KpApplication $application) {
        $this->authorizeApp($application);
        $application->update(['field_supervisor_id' => null]);
        return redirect()->route('field.students.index')->with('success','Mahasiswa di-unassign dari pengawas lapangan.');
    }

    private function authorizeApp(KpApplication $application) {
        abort_if($application->field_supervisor_id !== auth()->id(), 403);
    }
}
