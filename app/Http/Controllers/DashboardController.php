<?php

namespace App\Http\Controllers;

use App\Models\KpApplication;
use App\Models\MentoringLog;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index() {
        $role = auth()->user()->role;
        return match ($role) {
            'MAHASISWA'        => $this->studentDashboard(),
            'ADMIN_PRODI'      => to_route('admin-prodi.index'),
            'DOSEN_SUPERVISOR' => to_route('supervisor.dashboard'),
            'PENGAWAS_LAPANGAN'=> to_route('field.activities.index'),
            'SUPERADMIN'       => to_route('super-admin.index'),
            default            => view('dashboard'),
        };
    }

    private function studentDashboard() {
        $user = auth()->user();

        // Get KP applications
        $kpApplications = $user->kpApplications()->with(['company', 'student.supervisor'])->get();

        // Get recent mentoring logs (last 5)
        $recentMentoring = MentoringLog::whereHas('kpApplication', function($q) use ($user) {
            $q->where('student_id', $user->id);
        })->with(['kpApplication', 'supervisor'])->latest()->take(5)->get();

        // Get recent activity logs (last 5)
        $recentActivities = ActivityLog::whereHas('kpApplication', function($q) use ($user) {
            $q->where('student_id', $user->id);
        })->with('kpApplication')->latest()->take(5)->get();

        // Get active KP application
        $activeKp = $kpApplications->whereIn('status', ['APPROVED', 'ASSIGNED_SUPERVISOR', 'COMPLETED'])->first();

        return view('student.dashboard', compact(
            'kpApplications',
            'recentMentoring',
            'recentActivities',
            'activeKp'
        ));
    }
}
