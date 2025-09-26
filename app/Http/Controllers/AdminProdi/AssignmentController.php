<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index() {
        $queue = KpApplication::where('status','VERIFIED_PRODI')->latest()->get();
        $supervisors = User::where('role','DOSEN_SUPERVISOR')->get();
        $fieldSup = User::where('role','PENGAWAS_LAPANGAN')->get();
        return view('admin.assignments.index', compact('queue','supervisors','fieldSup'));
    }

    public function assignSupervisor(Request $request, KpApplication $kp) {
        $this->guard();
        $request->validate(['supervisor_id'=>'required|exists:users,id']);
        $kp->update([
            'assigned_supervisor_id'=>$request->supervisor_id,
            'status'=>'ASSIGNED_SUPERVISOR'
        ]);
        return back()->with('success','Dosen pembimbing ditetapkan.');
    }

    public function assignFieldSupervisor(Request $request, KpApplication $kp) {
        $this->guard();
        $request->validate(['field_supervisor_id'=>'required|exists:users,id']);
        $kp->update(['field_supervisor_id'=>$request->field_supervisor_id]);
        return back()->with('success','Pengawas lapangan ditetapkan.');
    }

    private function guard() {
        if (!in_array(auth()->user()->role, ['ADMIN_PRODI','SUPERADMIN'])) abort(403);
    }
}
