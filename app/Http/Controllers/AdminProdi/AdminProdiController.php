<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\Company;
use App\Models\User;
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
            'prodi' => 'required|string|max:255',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'MAHASISWA',
            'nim' => $request->nim,
            'prodi' => $request->prodi,
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
            'nim' => 'required|string|max:255|unique:users,nim,' . $student->id,
            'prodi' => 'required|string|max:255',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'supervisor_id' => $request->supervisor_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $student->update($updateData);

        // If supervisor_id was changed, update all their KP applications
        if ($request->has('supervisor_id')) {
            KpApplication::where('student_id', $student->id)
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
}
