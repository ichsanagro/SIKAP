<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionnaireTemplate;
use Illuminate\Http\Request;

class QuestionnaireResponseController extends Controller
{
    public function index(Request $request)
    {
        $query = QuestionnaireResponse::with(['template', 'user', 'kpApplication']);

        // Filter by template
        if ($request->filled('template_id')) {
            $query->where('questionnaire_template_id', $request->template_id);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('submitted_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $responses = $query->orderBy('submitted_at', 'desc')->paginate(20)->appends($request->query());

        return view('admin_prodi.questionnaire_responses.index', compact('responses'));
    }

    public function show(QuestionnaireResponse $response)
    {
        $response->load(['template.questions', 'user', 'kpApplication']);
        return view('admin_prodi.questionnaire_responses.show', compact('response'));
    }

    public function byTemplate(QuestionnaireTemplate $questionnaire)
    {
        $responses = $questionnaire->responses()
            ->with(['user', 'kpApplication'])
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);

        return view('admin_prodi.questionnaire_responses.by_template', compact('questionnaire', 'responses'));
    }

    public function export(Request $request)
    {
        $templateId = $request->get('template_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = QuestionnaireResponse::with(['template.questions', 'user', 'kpApplication']);

        if ($templateId) {
            $query->where('questionnaire_template_id', $templateId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('submitted_at', [$startDate, $endDate]);
        }

        $responses = $query->orderBy('submitted_at', 'desc')->get();

        // Generate CSV content
        $csvContent = $this->generateCsv($responses);

        $filename = 'questionnaire_responses_' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function generateCsv($responses)
    {
        $output = fopen('php://temp', 'r+');

        // Header
        fputcsv($output, [
            'ID Respon',
            'Judul Kuesioner',
            'Target Role',
            'Nama Responden',
            'Role Responden',
            'Tanggal Submit',
            'Jawaban'
        ]);

        foreach ($responses as $response) {
            $answers = [];
            $questions = $response->template->questions->sortBy('order');

            foreach ($questions as $question) {
                $answer = $response->responses[$question->id] ?? '-';
                if (is_array($answer)) {
                    $answer = implode(', ', $answer);
                }
                $answers[] = $question->question_text . ': ' . $answer;
            }

            fputcsv($output, [
                $response->id,
                $response->template->title,
                $response->template->target_role,
                $response->user->name,
                $response->user->role,
                $response->submitted_at->format('Y-m-d H:i:s'),
                implode('; ', $answers)
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}
