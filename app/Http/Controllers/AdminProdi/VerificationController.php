<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;

class VerificationController extends Controller
{
    public function index() {
        $list = KpApplication::where('status','SUBMITTED')->latest()->paginate(15);
        return view('admin.verifications.index', compact('list'));
    }

    public function approve(KpApplication $kp) {
        $this->guard();
        if ($kp->status !== 'SUBMITTED') abort(403);
        $kp->update(['status'=>'VERIFIED_PRODI']);
        return back()->with('success','Pengajuan disetujui. Lanjut penugasan supervisor.');
    }

    public function reject(KpApplication $kp) {
        $this->guard();
        if ($kp->status !== 'SUBMITTED') abort(403);
        $kp->update(['status'=>'REJECTED']);
        return back()->with('success','Pengajuan ditolak.');
    }

    private function guard() {
        if (!in_array(auth()->user()->role, ['ADMIN_PRODI','SUPERADMIN'])) abort(403);
    }
}
