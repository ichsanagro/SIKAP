<?php

namespace App\Http\Controllers;

use App\Models\MentoringLog;
use App\Models\SeminarApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SeminarApplicationController extends Controller
{
    public function index()
    {
        $applications = SeminarApplication::where('student_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('student.seminar.index', compact('applications'));
    }

    public function store(Request $request)
    {
        // Check if student has at least 10 approved mentoring logs
        $approvedMentoringCount = MentoringLog::where('student_id', Auth::id())
            ->where('status', 'APPROVED')
            ->count();

        if ($approvedMentoringCount < 10) {
            return redirect()->route('seminar.index')
                ->with('error', 'Anda harus menyelesaikan minimal 10 bimbingan yang disetujui sebelum dapat mengajukan seminar.');
        }

        $request->validate([
            'kegiatan_harian_kp' => 'required|url',
            'bimbingan_kp' => 'required|url',
        ]);

        SeminarApplication::create([
            'student_id' => Auth::id(),
            'kegiatan_harian_drive_link' => $request->kegiatan_harian_kp,
            'bimbingan_kp_drive_link' => $request->bimbingan_kp,
            'status' => 'PENDING',
        ]);

        return redirect()->route('seminar.index')
            ->with('success', 'Pengajuan seminar KP berhasil dikirim dan menunggu persetujuan Admin Prodi.');
    }
}
