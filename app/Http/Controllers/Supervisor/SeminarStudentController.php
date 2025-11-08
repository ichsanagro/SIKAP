<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\SeminarApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarStudentController extends Controller
{
    public function index()
    {
        $applications = SeminarApplication::with('student.kpApplications')
            ->where('examiner_id', Auth::id())
            ->where('status', 'APPROVED')
            ->latest()
            ->paginate(10);

        return view('supervisor.seminar.index', compact('applications'));
    }

    public function show(SeminarApplication $application)
    {
        // Ensure the current user is the examiner for this application
        if ($application->examiner_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat seminar ini.');
        }

        $application->load(['student', 'examiner', 'student.kpApplications.supervisor']);

        return view('supervisor.seminar.show', compact('application'));
    }

    public function updateSchedule(Request $request, SeminarApplication $application)
    {
        // Ensure the current user is the examiner for this application
        if ($application->examiner_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengatur jadwal seminar ini.');
        }

        $request->validate([
            'seminar_date' => 'required|date|after_or_equal:today',
            'seminar_time' => 'required|date_format:H:i',
            'seminar_location' => 'required|string|max:255',
            'examiner_notes' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'seminar_date' => $request->seminar_date,
            'seminar_time' => $request->seminar_time,
            'seminar_location' => $request->seminar_location,
            'examiner_notes' => $request->examiner_notes,
        ]);

        return redirect()->back()->with('success', 'Jadwal seminar berhasil diperbarui.');
    }
}
