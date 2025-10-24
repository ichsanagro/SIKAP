<?php

namespace App\Http\Controllers\FieldSupervisor;

use App\Http\Controllers\Controller;
use App\Models\FieldEvaluation;
use App\Models\KpApplication;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index() {
        $items = FieldEvaluation::with(['application.student'])
            ->where('supervisor_id', auth()->id())
            ->latest()->paginate(15);
        return view('field_supervisor.evaluations.index', compact('items'));
    }

    public function create() {
        $apps = KpApplication::with(['student', 'company'])
            ->where('field_supervisor_id', auth()->id())->get();
        return view('field_supervisor.evaluations.create', compact('apps'));
    }

    public function store(Request $req) {
        $data = $req->validate([
            'kp_application_id' => ['required','exists:kp_applications,id'],
            'rating'     => ['nullable','integer','min:0','max:100'],
            'evaluation' => ['nullable','string'],
            'feedback'   => ['nullable','string'],
        ]);

        KpApplication::where('id',$data['kp_application_id'])
            ->where('field_supervisor_id', auth()->id())->firstOrFail();

        $data['supervisor_id'] = auth()->id();
        FieldEvaluation::create($data);

        return redirect()->route('field.evaluations.index')->with('success','Evaluasi ditambahkan.');
    }

    public function edit(FieldEvaluation $evaluation) {
        $this->authorizeEval($evaluation);
        return view('field_supervisor.evaluations.edit', compact('evaluation'));
    }

    public function update(Request $req, FieldEvaluation $evaluation) {
        $this->authorizeEval($evaluation);
        $data = $req->validate([
            'rating'     => ['nullable','integer','min:0','max:100'],
            'evaluation' => ['nullable','string'],
            'feedback'   => ['nullable','string'],
        ]);
        $evaluation->update($data);
        return back()->with('success','Evaluasi diperbarui.');
    }

    private function authorizeEval(FieldEvaluation $evaluation) {
        abort_if($evaluation->supervisor_id !== auth()->id(), 403);
    }
}
