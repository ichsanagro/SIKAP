<?php

namespace App\Http\Controllers\FieldSupervisor;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;

class StudentController extends Controller
{
    public function index() {
        $apps = KpApplication::with(['student','company'])
            ->where('supervisor_id', auth()->id())
            ->latest()->paginate(15);
        return view('field_supervisor.students.index', compact('apps'));
    }

    public function show(KpApplication $application) {
        $this->authorizeApp($application);
        return view('field_supervisor.students.show', compact('application'));
    }

    // Hapus = unassign dari dosen lapangan ini
    public function destroy(KpApplication $application) {
        $this->authorizeApp($application);
        $application->update(['supervisor_id' => null]);
        return redirect()->route('field.students.index')->with('success','Mahasiswa di-unassign.');
    }

    private function authorizeApp(KpApplication $application) {
        abort_if($application->supervisor_id !== auth()->id(), 403);
    }
}
