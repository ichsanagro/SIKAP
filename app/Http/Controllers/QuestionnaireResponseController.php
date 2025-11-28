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
        if (!$questionnaire) {
            abort(404, 'Kuesioner tidak ditemukan.');
        }

        $user = Auth::user();

        // Check if user has already responded
        $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->where('user_id', $user->id)
            ->first();

        // If user has already responded, show the results regardless of role
        if ($existingResponse) {
            return view('questionnaires.show', compact('questionnaire', 'existingResponse'));
        }

        // Skip access check for admins and supervisors
        if (in_array($user->role, ['ADMIN_PRODI', 'SUPER_ADMIN', 'DOSEN_SUPERVISOR'])) {
            $questionnaire->load('questions');
            return view('questionnaires.fill', compact('questionnaire'));
        }

        // For non-admins who haven't responded, check target_role
        if ($questionnaire->target_role !== $user->role) {
            abort(403, 'Anda tidak memiliki akses ke kuesioner ini.');
        }

        $questionnaire->load('questions');
        return view('questionnaires.fill', compact('questionnaire'));
    }

    public function fill(QuestionnaireTemplate $questionnaire)
    {
        if (!$questionnaire) {
            abort(404, 'Kuesioner tidak ditemukan.');
        }

        $user = Auth::user();

        // Skip access check for admins and supervisors
        if (in_array($user->role, ['ADMIN_PRODI', 'SUPER_ADMIN', 'DOSEN_SUPERVISOR'])) {
            // Check if user has already responded
            $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingResponse) {
                return redirect()->route('questionnaires.show', $questionnaire)->with('info', 'Anda sudah mengisi kuesioner ini.');
            }

            $questionnaire->load('questions');
            return view('questionnaires.fill', compact('questionnaire'));
        }

        // Check if user can access this questionnaire (only check target_role for non-admins)
        if ($questionnaire->target_role !== $user->role) {
            abort(403, 'Anda tidak memiliki akses ke kuesioner ini.');
        }

        // Check if user has already responded
        $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingResponse) {
            return redirect()->route('questionnaires.show', $questionnaire)->with('info', 'Anda sudah mengisi kuesioner ini.');
        }

        $questionnaire->load('questions');
        return view('questionnaires.fill', compact('questionnaire'));
    }

    public function store(Request $request, QuestionnaireTemplate $questionnaire = null)
    {
        $user = Auth::user();

        // For supervisors, get questionnaire from hidden input since route doesn't pass it
        if ($user->role === 'DOSEN_SUPERVISOR' && !$questionnaire) {
            $questionnaireId = $request->input('questionnaire_id');
            $questionnaire = QuestionnaireTemplate::findOrFail($questionnaireId);
        }

        // Skip access check for admins and supervisors
        if (in_array($user->role, ['ADMIN_PRODI', 'SUPER_ADMIN', 'DOSEN_SUPERVISOR'])) {
            // Check if user has already responded
            $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingResponse) {
                $redirectRoute = $user->role === 'DOSEN_SUPERVISOR' ? 'supervisor.questionnaires.index' : 'questionnaires.index';
                return redirect()->route($redirectRoute)->with('error', 'Anda sudah mengisi kuesioner ini.');
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

            $redirectRoute = $user->role === 'DOSEN_SUPERVISOR' ? 'supervisor.questionnaires.index' : 'questionnaires.index';
            return redirect()->route($redirectRoute)->with('success', 'Kuesioner berhasil disimpan.');
        }

        // Check if user can access this questionnaire (only check target_role for non-admins)
        if ($questionnaire->target_role !== $user->role) {
            abort(403, 'Anda tidak memiliki akses ke kuesioner ini.');
        }

        // Check if user has already responded
        $existingResponse = QuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingResponse) {
            // Redirect based on role
            if ($user->role === 'DOSEN_SUPERVISOR') {
                return redirect()->route('supervisor.questionnaires.index')->with('error', 'Anda sudah mengisi kuesioner ini.');
            }
            return redirect()->route('questionnaires.index')->with('error', 'Anda sudah mengisi kuesioner ini.');
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
