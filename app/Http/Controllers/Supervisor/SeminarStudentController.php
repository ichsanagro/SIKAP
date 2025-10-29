<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\SeminarApplication;
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
}
