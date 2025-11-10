<?php

namespace App\Http\Controllers\FieldSupervisor;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\KpScore;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index() {
        $applications = KpApplication::with(['student', 'score', 'company'])
            ->where('field_supervisor_id', auth()->id())
            ->latest()->paginate(15);
        return view('field_supervisor.scores.index', compact('applications'));
    }

    public function show(KpScore $score) {
        $this->authorizeScore($score);
        return view('field_supervisor.scores.show', compact('score'));
    }

    public function create(Request $request) {
        $apps = KpApplication::with('student')
            ->where('field_supervisor_id', auth()->id())->get();
        $selectedApp = null;
        if ($request->has('application')) {
            $selectedApp = KpApplication::with('student')
                ->where('id', $request->application)
                ->where('field_supervisor_id', auth()->id())
                ->first();
        }
        return view('field_supervisor.scores.create', compact('apps', 'selectedApp'));
    }

    public function store(Request $req) {
        $data = $req->validate([
            'kp_application_id' => ['required','exists:kp_applications,id'],
            'discipline' => ['required','integer','min:1','max:100'],
            'skill'      => ['required','integer','min:1','max:100'],
            'attitude'   => ['required','integer','min:1','max:100'],
            'report'     => ['required','integer','min:1','max:100'],
            'mastery'    => ['required','integer','min:1','max:100'],
            'notes'      => ['nullable','string'],
        ]);

        $app = KpApplication::where('id',$data['kp_application_id'])
            ->where('field_supervisor_id', auth()->id())->firstOrFail();

        $data['supervisor_id'] = auth()->id();
        $data['final_score'] = round(($data['discipline'] + $data['skill'] + $data['attitude'] + $data['report'] + $data['mastery'])/5, 2);

        $score = KpScore::create($data);
        return redirect()->route('field.scores.index')->with('success','Nilai tersimpan.');
    }

    public function edit(KpScore $score) {
        $this->authorizeScore($score);
        return view('field_supervisor.scores.edit', compact('score'));
    }

    public function update(Request $req, KpScore $score) {
        $this->authorizeScore($score);
        $data = $req->validate([
            'discipline' => ['required','integer','min:1','max:100'],
            'skill'      => ['required','integer','min:1','max:100'],
            'attitude'   => ['required','integer','min:1','max:100'],
            'report'     => ['required','integer','min:1','max:100'],
            'mastery'    => ['required','integer','min:1','max:100'],
            'notes'      => ['nullable','string'],
        ]);
        $data['final_score'] = round(($data['discipline'] + $data['skill'] + $data['attitude'] + $data['report'] + $data['mastery'])/5, 2);
        $score->update($data);
        return redirect()->route('field.scores.index')->with('success','Nilai berhasil diperbarui.');
    }

    public function destroy(KpScore $score) {
        $this->authorizeScore($score);
        $score->delete();
        return redirect()->route('field.scores.index')->with('success','Nilai dihapus.');
    }

    private function authorizeScore(KpScore $score) {
        abort_if($score->supervisor_id !== auth()->id(), 403);
    }
}
