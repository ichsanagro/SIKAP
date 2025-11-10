<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireResponseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questionnaires = QuestionnaireTemplate::forRole($user->role)
            ->active()
            ->with(['questions', 'responses' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return view('questionnaires.index', compact('questionnaires'));
    }

    public function show(QuestionnaireTemplate $questionnaire)
    {
        $user = Auth::user();

        // Check if user can access this questionnaire
        if ($questionnaire->target_role !== $user->role || !$questionnaire->is_active) {
            abort(403, 'Anda tidak memiliki akses ke kuesioner ini.');
        }

        // Check if user has already responded
        $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingResponse) {
            return view('questionnaires.show', compact('questionnaire', 'existingResponse'));
        }

        $questionnaire->load('questions');
        return view('questionnaires.fill', compact('questionnaire'));
    }

    public function store(Request $request, QuestionnaireTemplate $questionnaire)
    {
        $user = Auth::user();

        // Check if user can access this questionnaire
        if ($questionnaire->target_role !== $user->role || !$questionnaire->is_active) {
            abort(403, 'Anda tidak memiliki akses ke kuesioner ini.');
        }

        // Check if user has already responded
        $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingResponse) {
            return redirect()->back()->with('error', 'Anda sudah mengisi kuesioner ini.');
        }

        $questionnaire->load('questions');

        // Validate responses
        $rules = [];
        foreach ($questionnaire->questions as $question) {
            $fieldName = 'question_' . $question->id;
            if ($question->is_required) {
                if (in_array($question->question_type, ['radio', 'select'])) {
                    $rules[$fieldName] = 'required';
                } elseif ($question->question_type === 'checkbox') {
                    $rules[$fieldName] = 'required|array|min:1';
                } else {
                    $rules[$fieldName] = 'required';
                }
            }
        }

        $request->validate($rules);

        // Prepare responses data
        $responses = [];
        foreach ($questionnaire->questions as $question) {
            $fieldName = 'question_' . $question->id;
            $responses[$question->id] = $request->input($fieldName);
        }

        // Create response
        QuestionnaireResponse::create([
            'questionnaire_template_id' => $questionnaire->id,
            'user_id' => $user->id,
            'kp_application_id' => $user->role === 'MAHASISWA' ? $user->kpApplications->first()?->id : null,
            'responses' => $responses,
            'submitted_at' => now(),
        ]);

        return redirect()->route('questionnaires.index')->with('success', 'Kuesioner berhasil disimpan.');
    }
}
