<?php

namespace App\Http\Controllers;

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
