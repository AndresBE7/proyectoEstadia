<?php

namespace App\Exports;

use App\Models\SurveyResponse;
use Maatwebsite\Excel\Excel;

class SurveyReportExport
{
    protected $survey_id;
    protected $group_id;

    public function __construct($survey_id = null, $group_id = null)
    {
        $this->survey_id = $survey_id;
        $this->group_id = $group_id;
    }

    public function handle()
    {
        $responsesQuery = SurveyResponse::with('survey', 'user')
            ->join('users', 'users.id', '=', 'survey_responses.user_id')
            ->join('surveys', 'surveys.id', '=', 'survey_responses.survey_id')
            ->select('survey_responses.*');

        if ($this->survey_id) {
            $responsesQuery->where('survey_responses.survey_id', $this->survey_id);
        }

        $responses = $responsesQuery->get();
        $data = $this->processReportData($responses);

        \Excel::create('reporte_encuestas_' . date('Ymd_His'), function($excel) use ($data) {
            $excel->sheet('Encuestas', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

    private function processReportData($responses)
    {
        if ($responses->isEmpty()) {
            return [['Respuesta']]; // Retorno por defecto si no hay datos
        }

        $survey = $responses->first()->survey;
        $questions = $survey->questions;

        if (is_string($questions)) {
            $questions = json_decode($questions, true) ?: [];
        }

        $headings = ['Respuesta'];
        foreach ($questions as $index => $question) {
            $headings[] = "Pregunta " . ($index + 1) . ": " . $question;
        }

        $rows = [];
        $rows[] = $headings;

        foreach ($responses as $response) {
            $row = ['Usuario: ' . ($response->user ? $response->user->name : 'Desconocido')];
            $answers = $response->answers;

            if (is_string($answers)) {
                $answers = json_decode($answers, true) ?: [];
            } elseif (!is_array($answers)) {
                $answers = [];
            }

            $totalQuestions = count($questions);
            for ($i = 0; $i < $totalQuestions; $i++) {
                $row[] = $answers[$i] ?? 0; // Si no hay respuesta, usar 0
            }

            $rows[] = $row;
        }

        return $rows;
    }
}