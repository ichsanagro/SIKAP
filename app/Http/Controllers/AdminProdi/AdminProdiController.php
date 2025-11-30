<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\Company;
use App\Models\User;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProdiController extends Controller
{
    public function dashboard()
    {
        // Statistics relevant to Admin Prodi
        $stats = [
            'applications' => KpApplication::count(),
            'companies' => Company::count(),
            'assigned_supervisors' => KpApplication::whereNotNull('assigned_supervisor_id')->count(),
            'assigned_field_supervisors' => KpApplication::whereNotNull('field_supervisor_id')->count(),
            'students' => User::where('role', 'MAHASISWA')->count(),
            'field_supervisors' => User::where('role', 'PENGAWAS_LAPANGAN')->count(),
            'questionnaire_responses' => QuestionnaireResponse::count(),
        ];

        return view('admin_prodi.index', compact('stats'));
    }

    // Student Management Methods
    public function students()
    {
        $students = User::where('role', 'MAHASISWA')
            ->with('kpApplications')
            ->paginate(20);

        return view('admin_prodi.students.index', compact('students'));
    }

    public function createStudent()
    {
        $supervisors = User::where('role', 'DOSEN_SUPERVISOR')->active()->get();
        return view('admin_prodi.students.create', compact('supervisors'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|max:255|unique:users',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'MAHASISWA',
            'nim' => $request->nim,
            'supervisor_id' => $request->supervisor_id,
            'is_active' => true,
        ]);

        return redirect()->route('admin-prodi.students.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function editStudent(User $student)
    {
        // Ensure it's a MAHASISWA
        if ($student->role !== 'MAHASISWA') {
            abort(404);
        }

        $supervisors = User::where('role', 'DOSEN_SUPERVISOR')->active()->get();
        return view('admin_prodi.students.edit', compact('student', 'supervisors'));
    }

    public function updateStudent(Request $request, User $student)
    {
        // Ensure it's a MAHASISWA
        if ($student->role !== 'MAHASISWA') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'supervisor_id' => $request->supervisor_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $student->update($updateData);

        // If supervisor_id was changed, update KP applications that are eligible for mentoring
        // Only update KP that are APPROVED or in progress (ASSIGNED_SUPERVISOR, APPROVED, COMPLETED)
        if ($request->has('supervisor_id')) {
            KpApplication::where('student_id', $student->id)
                ->whereIn('status', ['ASSIGNED_SUPERVISOR', 'APPROVED', 'COMPLETED'])
                ->update(['assigned_supervisor_id' => $request->supervisor_id]);
        }

        return redirect()->route('admin-prodi.students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroyStudent(User $student)
    {
        // Ensure it's a MAHASISWA
        if ($student->role !== 'MAHASISWA') {
            abort(404);
        }

        // Soft delete or hard delete? For now, hard delete as per SuperAdmin pattern
        $student->delete();

        return redirect()->route('admin-prodi.students.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    public function toggleStudentActive(User $student)
    {
        // Ensure it's a MAHASISWA
        if ($student->role !== 'MAHASISWA') {
            abort(404);
        }

        $student->update(['is_active' => !$student->is_active]);

        $status = $student->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin-prodi.students.index')->with('success', "Mahasiswa berhasil {$status}.");
    }

    // Field Supervisor Management Methods
    public function fieldSupervisors()
    {
        $fieldSupervisors = User::where('role', 'PENGAWAS_LAPANGAN')
            ->with('supervisedCompanies')
            ->paginate(20);

        return view('admin_prodi.field_supervisors.index', compact('fieldSupervisors'));
    }

    public function createFieldSupervisor()
    {
        $companies = Company::all();

        $customCompanies = KpApplication::whereNull('company_id')
            ->whereNotNull('custom_company_name')
            ->where('custom_company_name', '!=', '')
            ->distinct()
            ->pluck('custom_company_name')
            ->filter()
            ->values()
            ->toArray();

        return view('admin_prodi.field_supervisors.create', compact('companies', 'customCompanies'));
    }

    public function storeFieldSupervisor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_ids' => 'nullable|array',
            'company_ids.*' => 'exists:companies,id',
            'custom_company_names' => 'nullable|array',
            'custom_company_names.*' => 'string|max:255',
        ]);

        $fieldSupervisor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'PENGAWAS_LAPANGAN',
            'is_active' => true,
        ]);

        // Attach existing companies if provided
        if ($request->company_ids) {
            $fieldSupervisor->supervisedCompanies()->attach($request->company_ids);
        }

        // Handle custom companies
        $customCompanyIds = [];
        if ($request->custom_company_names) {
            foreach ($request->custom_company_names as $customName) {
                $trimmedName = trim($customName);
                if (!empty($trimmedName)) {
                    $company = Company::firstOrCreate(
                        ['name' => $trimmedName],
                        ['name' => $trimmedName]
                    );
                    $fieldSupervisor->supervisedCompanies()->attach($company->id);
                    $customCompanyIds[] = $company->id;
                }
            }
        }

        // Auto-assign to relevant KP applications
        $selectedCompanyIds = array_unique(array_merge($request->company_ids ?? [], $customCompanyIds));
        $selectedCustomNames = array_map('trim', $request->custom_company_names ?? []);
        $selectedCustomNames = array_filter($selectedCustomNames); // Remove empty

        KpApplication::whereNull('field_supervisor_id')
            ->where('status', 'APPROVED')
            ->where(function ($query) use ($selectedCompanyIds, $selectedCustomNames) {
                if (!empty($selectedCompanyIds)) {
                    $query->orWhereIn('company_id', $selectedCompanyIds);
                }
                if (!empty($selectedCustomNames)) {
                    $query->orWhere(function ($subQuery) use ($selectedCustomNames) {
                        $subQuery->whereNull('company_id')
                            ->whereIn('custom_company_name', $selectedCustomNames);
                    });
                }
            })
            ->update(['field_supervisor_id' => $fieldSupervisor->id]);

        return redirect()->route('admin-prodi.field-supervisors.index')->with('success', 'Pengawas Lapangan berhasil ditambahkan.');
    }

    public function editFieldSupervisor(User $fieldSupervisor)
    {
        // Ensure it's a PENGAWAS_LAPANGAN
        if ($fieldSupervisor->role !== 'PENGAWAS_LAPANGAN') {
            abort(404);
        }

        $companies = Company::all();

        $customCompanies = KpApplication::whereNull('company_id')
            ->whereNotNull('custom_company_name')
            ->where('custom_company_name', '!=', '')
            ->distinct()
            ->pluck('custom_company_name')
            ->filter()
            ->values()
            ->toArray();

        return view('admin_prodi.field_supervisors.edit', compact('fieldSupervisor', 'companies', 'customCompanies'));
    }

    public function updateFieldSupervisor(Request $request, User $fieldSupervisor)
    {
        // Ensure it's a PENGAWAS_LAPANGAN
        if ($fieldSupervisor->role !== 'PENGAWAS_LAPANGAN') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $fieldSupervisor->id,
            'password' => 'nullable|string|min:8|confirmed',
            'company_ids' => 'nullable|array',
            'company_ids.*' => 'exists:companies,id',
            'custom_company_names' => 'nullable|array',
            'custom_company_names.*' => 'string|max:255',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $fieldSupervisor->update($updateData);

        // Sync existing companies
        $companyIds = $request->company_ids ?? [];

        // Handle custom companies
        if ($request->custom_company_names) {
            foreach ($request->custom_company_names as $customName) {
                $company = Company::firstOrCreate(
                    ['name' => trim($customName)],
                    ['name' => trim($customName)]
                );
                $companyIds[] = $company->id;
            }
        }

        $fieldSupervisor->supervisedCompanies()->sync($companyIds);

        return redirect()->route('admin-prodi.field-supervisors.index')->with('success', 'Data pengawas lapangan berhasil diperbarui.');
    }

    public function destroyFieldSupervisor(User $fieldSupervisor)
    {
        // Ensure it's a PENGAWAS_LAPANGAN
        if ($fieldSupervisor->role !== 'PENGAWAS_LAPANGAN') {
            abort(404);
        }

        // Detach from companies first
        $fieldSupervisor->supervisedCompanies()->detach();

        // Hard delete
        $fieldSupervisor->delete();

        return redirect()->route('admin-prodi.field-supervisors.index')->with('success', 'Pengawas Lapangan berhasil dihapus.');
    }

    public function toggleFieldSupervisorActive(User $fieldSupervisor)
    {
        // Ensure it's a PENGAWAS_LAPANGAN
        if ($fieldSupervisor->role !== 'PENGAWAS_LAPANGAN') {
            abort(404);
        }

        $fieldSupervisor->update(['is_active' => !$fieldSupervisor->is_active]);

        $status = $fieldSupervisor->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin-prodi.field-supervisors.index')->with('success', "Pengawas Lapangan berhasil {$status}.");
    }
}
