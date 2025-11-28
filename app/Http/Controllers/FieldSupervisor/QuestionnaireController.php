<?php

namespace App\Http\Controllers\FieldSupervisor;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionnaireTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $questionnaires = QuestionnaireTemplate::where('target_role', $user->role)
            ->where('is_active', true)
            ->with(['responses' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return view('field_supervisor.questionnaires.index', compact('questionnaires'));
    }

    public function show(QuestionnaireTemplate $questionnaire)
    {
        $user = Auth::user();

        // Check if user has already responded
        $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->where('user_id', $user->id)
            ->first();

        // If user has already responded, show the results regardless of role
        if ($existingResponse) {
            return view('field_supervisor.questionnaires.show', compact('questionnaire', 'existingResponse'));
        }

        // For users who haven't responded, check target_role and active status
        if ($questionnaire->target_role !== $user->role || !$questionnaire->is_active) {
            abort(403, 'Anda tidak memiliki akses ke kuesioner ini.');
        }

        $questionnaire->load('questions');
        return view('field_supervisor.questionnaires.fill', compact('questionnaire'));
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
            return redirect()->route('field.questionnaires.index')->with('error', 'Anda sudah mengisi kuesioner ini.');
        }

        $questionnaire->load('questions');

        $validatedData = $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'nullable',
        ]);

        $responses = [];
        foreach ($questionnaire->questions as $question) {
            $responseValue = $validatedData['responses'][$question->id] ?? '';

            // Handle checkbox arrays
            if (is_array($responseValue)) {
                $responseValue = implode(', ', $responseValue);
            }

            $responses[] = [
                'questionnaire_question_id' => $question->id,
                'response' => $responseValue,
            ];
        }

        QuestionnaireResponse::create([
            'questionnaire_template_id' => $questionnaire->id,
            'user_id' => $user->id,
            'responses' => $responses,
            'submitted_at' => now(),
        ]);

        return redirect()->route('field.questionnaires.index')->with('success', 'Kuesioner berhasil disimpan.');
    }

    public function fill(QuestionnaireTemplate $questionnaire)
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
            return redirect()->route('field.questionnaires.show', $questionnaire)->with('error', 'Anda sudah mengisi kuesioner ini.');
        }

        $questionnaire->load('questions');
        return view('field_supervisor.questionnaires.fill', compact('questionnaire'));
    }
}
