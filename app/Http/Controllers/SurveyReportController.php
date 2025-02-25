<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ClassModel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;
use App\Exports\SurveyReportExport;
use Maatwebsite\Excel\Facades\Excel;
class SurveyReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period');
        $group_id = $request->input('group_id');
        $survey_id = $request->input('survey_id');

        // Listas para los filtros
        $surveys = Survey::all();
        $groups = ClassModel::where('is_delete', 0)->get();
        $periods = SurveyResponse::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->distinct()
            ->get()
            ->map(function ($item) {
                return Carbon::create($item->year, $item->month)->format('Y-m');
            })->unique();

        // Consulta base de respuestas
        $responsesQuery = SurveyResponse::with('survey', 'user')
            ->join('users', 'users.id', '=', 'survey_responses.user_id')
            ->join('surveys', 'surveys.id', '=', 'survey_responses.survey_id')
            ->select('survey_responses.*');

        // Aplicar filtros
        if ($period) {
            $date = Carbon::createFromFormat('Y-m', $period);
            $responsesQuery->whereYear('survey_responses.created_at', $date->year)
                           ->whereMonth('survey_responses.created_at', $date->month);
        }
        if ($group_id) {
            $responsesQuery->where('users.grupo_id', $group_id);
        }
        if ($survey_id) {
            $responsesQuery->where('survey_id', $survey_id);
        }

        $responses = $responsesQuery->get();
        $reportData = $this->processReportData($responses);

        return view('admin.surveys.reports.index', compact('surveys', 'groups', 'periods', 'reportData', 'period', 'group_id', 'survey_id'));
    }

    public function exportPdf(Request $request)
    {
        $survey_id = $request->input('survey_id');
        $group_id = $request->input('group_id');
    
        $responsesQuery = SurveyResponse::with('survey', 'user')
            ->join('users', 'users.id', '=', 'survey_responses.user_id')
            ->join('surveys', 'surveys.id', '=', 'survey_responses.survey_id')
            ->select('survey_responses.*');
    
        if ($survey_id) {
            $responsesQuery->where('survey_id', $survey_id);
        }
    
        $responses = $responsesQuery->get();
        $reportData = $this->processReportData($responses);
    
        $surveyTitle = $survey_id ? Survey::find($survey_id)->title : 'Todas';
        $groupName = $group_id ? ClassModel::find($group_id)->nombre : 'Todos';
    
        $pdf = Pdf::loadView('admin.surveys.reports.pdf', compact('reportData', 'survey_id', 'group_id', 'surveyTitle', 'groupName'));
        return $pdf->download('reporte_encuestas_' . now()->format('Ymd_His') . '.pdf');
    }
    private function processReportData($responses)
    {
        if ($responses->isEmpty()) {
            return [
                'questions' => [],
                'averages' => [],
                'counts' => [],
                'total_responses' => 0
            ];
        }
    
        $survey = $responses->first()->survey;
        $questions = $survey->questions; // Esto ya usa el accesor ajustado
    
        if (empty($questions)) {
            Log::warning('No hay preguntas válidas en la encuesta:', ['survey_id' => $survey->id]);
            return [
                'questions' => [],
                'averages' => [],
                'counts' => [],
                'total_responses' => $responses->count()
            ];
        }
    
        $averages = [];
        $counts = [];
        $totalResponses = $responses->count();
    
        foreach ($questions as $index => $question) {
            // Obtener las respuestas para esta pregunta específica
            $answers = $responses->pluck("answers.{$index}")->filter()->values();
            $averages[$index] = $answers->avg() ?? 0; // Promedio o 0 si no hay respuestas
            $counts[$index] = array_fill(0, 6, 0); // Respuestas de 0 a 5
    
            foreach ($answers as $answer) {
                if (is_numeric($answer) && $answer >= 0 && $answer <= 5) {
                    $counts[$index][(int)$answer]++;
                }
            }
        }
    
        return [
            'questions' => $questions,
            'averages' => $averages,
            'counts' => $counts,
            'total_responses' => $totalResponses
        ];
    }
}