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
            'kegiatan_harian_kp' => 'required|file|mimes:pdf|max:10240', // 10MB
            'bimbingan_kp' => 'required|file|mimes:pdf|max:10240', // 10MB
        ]);

        $kegiatanPath = $request->file('kegiatan_harian_kp')->store('seminar', 'public');
        $bimbinganPath = $request->file('bimbingan_kp')->store('seminar', 'public');

        SeminarApplication::create([
            'student_id' => Auth::id(),
            'kegiatan_harian_path' => $kegiatanPath,
            'bimbingan_kp_path' => $bimbinganPath,
            'status' => 'PENDING',
        ]);

        return redirect()->route('seminar.index')
            ->with('success', 'Pengajuan seminar KP berhasil dikirim dan menunggu persetujuan Admin Prodi.');
    }
}
