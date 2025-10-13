<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KpApplication;
use App\Models\Company;
use App\Models\MentoringLog;
use App\Models\ActivityLog;
use App\Models\Report;
use App\Models\KpScore;
use App\Models\FieldEvaluation;
use App\Models\CompanyQuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // Overview statistics
        $stats = [
            'users' => User::count(),
            'applications' => KpApplication::count(),
            'companies' => Company::count(),
            'mentoring_logs' => MentoringLog::count(),
            'activity_logs' => ActivityLog::count(),
            'reports' => Report::count(),
            'scores' => KpScore::count(),
            'evaluations' => FieldEvaluation::count(),
            'quotas' => CompanyQuota::count(),
        ];

        return view('super_admin.index', compact('stats'));
    }

    public function index()
    {
        $users = User::with('kpApplications')->paginate(20);
        return view('super_admin.users.index', compact('users'));
    }

    public function applications()
    {
        $applications = KpApplication::with(['student', 'company', 'supervisor', 'fieldSupervisor'])->paginate(20);
        return view('super_admin.applications.index', compact('applications'));
    }

    public function companies()
    {
        $companies = Company::with('kpApplications')->paginate(20);
        return view('super_admin.companies.index', compact('companies'));
    }

    public function mentoringLogs()
    {
        $logs = MentoringLog::with(['kpApplication', 'student', 'supervisor'])->paginate(20);
        return view('super_admin.mentoring_logs.index', compact('logs'));
    }

    public function activityLogs()
    {
        $logs = ActivityLog::with(['kpApplication', 'student'])->paginate(20);
        return view('super_admin.activity_logs.index', compact('logs'));
    }

    public function reports()
    {
        $reports = Report::with(['kpApplication', 'student'])->paginate(20);
        return view('super_admin.reports.index', compact('reports'));
    }

    public function scores()
    {
        $scores = KpScore::with(['application', 'supervisor'])->paginate(20);
        return view('super_admin.scores.index', compact('scores'));
    }

    public function evaluations()
    {
        $evaluations = FieldEvaluation::with(['application', 'supervisor'])->paginate(20);
        return view('super_admin.evaluations.index', compact('evaluations'));
    }

    public function quotas()
    {
        $quotas = CompanyQuota::with('company')->paginate(20);
        return view('super_admin.quotas.index', compact('quotas'));
    }

    // CRUD methods for users
    public function create()
    {
        return view('super_admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:MAHASISWA,ADMIN_PRODI,DOSEN_SUPERVISOR,PENGAWAS_LAPANGAN,SUPERADMIN',
            'nim' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'is_active' => true,
        ]);

        return redirect()->route('super-admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('super_admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:MAHASISWA,ADMIN_PRODI,DOSEN_SUPERVISOR,PENGAWAS_LAPANGAN,SUPERADMIN',
            'nim' => 'nullable|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'supervisor_id' => $request->supervisor_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // If supervisor_id was changed for a MAHASISWA, update all their KP applications
        if ($user->role === 'MAHASISWA' && $request->has('supervisor_id')) {
            KpApplication::where('student_id', $user->id)
                ->update(['assigned_supervisor_id' => $request->supervisor_id]);
        }

        return redirect()->route('super-admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Hard delete - permanently remove user from database
        $user->delete();

        return redirect()->route('super-admin.users.index')->with('success', 'User deleted permanently from database.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('super-admin.users.index')->with('success', "User {$status} successfully.");
    }
}
