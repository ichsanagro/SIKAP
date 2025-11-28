<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function create($kpId)
    {
        $questionnaire = Questionnaire::where('kp_application_id', $kpId)->first();

        if (!$questionnaire) {
            return redirect()->back()->with('error', 'Kuesioner tidak ditemukan.');
        }

        return view('questionnaire.create', compact('questionnaire'));
    }

    public function store(Request $request, $kpId)
    {
        $questionnaire = Questionnaire::where('kp_application_id', $kpId)->first();

        if (!$questionnaire) {
            return redirect()->back()->with('error', 'Kuesioner tidak ditemukan.');
        }

        // Validate the request
        $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|string',
        ]);

        // Save responses
        $questionnaire->responses = $request->input('responses');
        $questionnaire->save();

        return redirect()->route('dashboard')->with('success', 'Kuesioner berhasil disimpan.');
    }
}
