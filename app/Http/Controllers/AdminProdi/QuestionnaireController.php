<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaires = QuestionnaireTemplate::with('questions')->get();
        return view('admin_prodi.questionnaires.index', compact('questionnaires'));
    }

    public function create()
    {
        return view('admin_prodi.questionnaires.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_role' => 'required|in:MAHASISWA,DOSEN_SUPERVISOR,PENGAWAS_LAPANGAN',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:text,textarea,radio,checkbox,select',
            'questions.*.options' => 'nullable|array',
            'questions.*.is_required' => 'boolean',
        ]);

        DB::transaction(function () use ($request) {
            $template = QuestionnaireTemplate::create([
                'title' => $request->title,
                'description' => $request->description,
                'target_role' => $request->target_role,
                'is_active' => true,
            ]);

            foreach ($request->questions as $index => $questionData) {
                QuestionnaireQuestion::create([
                    'questionnaire_template_id' => $template->id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'options' => in_array($questionData['question_type'], ['radio', 'checkbox', 'select']) ? $questionData['options'] : null,
                    'is_required' => $questionData['is_required'] ?? true,
                    'order' => $index + 1,
                ]);
            }
        });

        return redirect()->route('admin-prodi.questionnaires.index')
            ->with('success', 'Kuesioner berhasil dibuat.');
    }

    public function show(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->load('questions');
        return view('admin_prodi.questionnaires.show', compact('questionnaire'));
    }

    public function edit(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->load('questions');
        return view('admin_prodi.questionnaires.edit', compact('questionnaire'));
    }

    public function update(Request $request, QuestionnaireTemplate $questionnaire)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_role' => 'required|in:MAHASISWA,DOSEN_SUPERVISOR,PENGAWAS_LAPANGAN',
            'is_active' => 'boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:text,textarea,radio,checkbox,select',
            'questions.*.options' => 'nullable|array',
            'questions.*.is_required' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $questionnaire) {
            $questionnaire->update([
                'title' => $request->title,
                'description' => $request->description,
                'target_role' => $request->target_role,
                'is_active' => $request->is_active ?? true,
            ]);

            // Hapus pertanyaan yang ada
            $questionnaire->questions()->delete();

            // Buat pertanyaan baru
            foreach ($request->questions as $index => $questionData) {
                QuestionnaireQuestion::create([
                    'questionnaire_template_id' => $questionnaire->id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'options' => in_array($questionData['question_type'], ['radio', 'checkbox', 'select']) ? $questionData['options'] : null,
                    'is_required' => $questionData['is_required'] ?? true,
                    'order' => $index + 1,
                ]);
            }
        });

        return redirect()->route('admin-prodi.questionnaires.index')
            ->with('success', 'Kuesioner berhasil diperbarui.');
    }

    public function destroy(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->delete();
        return redirect()->route('admin-prodi.questionnaires.index')
            ->with('success', 'Kuesioner berhasil dihapus.');
    }

    public function toggleActive(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->update(['is_active' => !$questionnaire->is_active]);
        return redirect()->back()
            ->with('success', 'Status kuesioner berhasil diubah.');
    }
}
