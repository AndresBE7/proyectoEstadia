<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('admin.surveys.create');
    }

    public function index_survey()
    {
        $surveys = Survey::all();
        return view('student.surveys.show', compact('surveys'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array', // Asegúrate de que las preguntas sean un array
            'expiration_date' => 'required|date',
        ]);
    
        // Convertir el array de preguntas a JSON
        $questions = json_encode($validated['questions']);
    
        // Guardar la encuesta
        Survey::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'questions' => $questions, // Guardar como JSON
            'expiration_date' => $validated['expiration_date'],
            'is_active' => true,
        ]);
    
        return redirect()
            ->route('admin.surveys.index')
            ->with('success', 'Encuesta creada exitosamente.');
    }

    public function edit(Survey $survey)
    {
        if ($survey->responses()->count() > 0) {
            return redirect()
                ->route('admin.surveys.index')
                ->with('error', 'No se puede editar una encuesta que ya tiene respuestas.');
        }

        return view('admin.surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        if ($survey->responses()->count() > 0) {
            return redirect()
                ->route('admin.surveys.index')
                ->with('error', 'No se puede editar una encuesta que ya tiene respuestas.');
        }
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array', // Asegúrate de que 'questions' sea un array
        ]);
    
        // Convertir el array de preguntas a JSON antes de actualizar
        $validated['questions'] = json_encode($validated['questions']);
    
        $survey->update($validated);
    
        return redirect()
            ->route('admin.surveys.index')
            ->with('success', 'Encuesta modificada exitosamente.');
    }
    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        
        // Verifica si la encuesta tiene respuestas antes de eliminarla
        if ($survey->responses()->count() > 0) {
            return redirect()
                ->route('admin.surveys.index')
                ->with('error', 'No se puede eliminar una encuesta que tiene respuestas.');
        }

        $survey->delete();

        return redirect()
            ->route('admin.surveys.index')
            ->with('success', 'Encuesta eliminada exitosamente.');
    }

    public function showRespondForm(Survey $survey)
    {
        // Verificar si la encuesta está activa o no
        if (!$survey->is_active) {
            return redirect()
                ->route('admin.surveys.index')
                ->with('error', 'La encuesta ya no está activa.');
        }
    
        return view('surveys.respond', compact('survey'));
    }
    
    public function activate(Survey $survey)
    {
        try {
            Log::info('Iniciando activación de encuesta:', ['survey_id' => $survey->id, 'current_is_active' => $survey->is_active]);
    
            // Verificar si el nivel académico de los usuarios es "Secundaria"
            $eligibleUsers = \App\Models\User::where('nivel_academico', 'Secundaria')->get();
            Log::info('Usuarios elegibles encontrados:', ['count' => $eligibleUsers->count()]);
    
            if ($eligibleUsers->isEmpty()) {
                Log::warning('No hay usuarios elegibles para activar la encuesta:', ['survey_id' => $survey->id]);
                return redirect()
                    ->route('admin.surveys.index')
                    ->with('error', 'No hay alumnos de nivel secundario para activar la encuesta.');
            }
    
            // Cambiar is_active a true y guardar
            $survey->is_active = true;
            $survey->save();
            Log::info('Encuesta activada en memoria:', ['survey_id' => $survey->id, 'new_is_active' => $survey->is_active]);
    
            // Verificar si se guardó en la base de datos
            $updatedSurvey = Survey::find($survey->id);
            Log::info('Estado después de guardar:', ['survey_id' => $updatedSurvey->id, 'is_active' => $updatedSurvey->is_active]);
    
            return redirect()
                ->route('admin.surveys.index')
                ->with('success', 'Encuesta activada exitosamente.');
                
        } catch (\Exception $e) {
            Log::error('Error al activar la encuesta:', [
                'survey_id' => $survey->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('admin.surveys.index')
                ->with('error', 'No se pudo activar la encuesta. Por favor, intente nuevamente.');
        }
    }

    public function results(Survey $survey)
    {
        $responses = $survey->responses()
            ->with('user')
            ->get()
            ->groupBy('question_id');

        return view('admin.surveys.results', compact('survey', 'responses'));
    }

    public function submit(Request $request, Survey $survey)
    {
        // Validar las respuestas
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|between:0,5',
        ]);
    
        // Guardar todas las respuestas en un solo registro
        $survey->responses()->create([
            'user_id' => auth()->id(),
            'answers' => $validated['answers'], // Guardar todo el array de respuestas
        ]);
    
        return redirect()
            ->route('surveys.respond', $survey->id)
            ->with('success', '¡Gracias por responder la encuesta!');
    }

    public function userResponses(Survey $survey, $userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        
        $response = $survey->responses()
            ->where('user_id', $userId)
            ->first();
        
        $questions = $survey->questions;
        // Forzar la conversión a array si es una cadena JSON
        if (is_string($questions)) {
            $decodedQuestions = json_decode($questions, true);
            if (is_array($decodedQuestions)) {
                $questions = $decodedQuestions;
            } else {
                // Si no es JSON válido, intentar dividir por comas como respaldo
                $questions = array_map('trim', explode(',', $questions));
            }
        } elseif (!is_array($questions)) {
            // Si no es ni cadena ni array, usar un array vacío
            $questions = [];
        }
    
        // Depuración para confirmar el resultado
        \Illuminate\Support\Facades\Log::info('Preguntas procesadas en userResponses:', [
            'survey_id' => $survey->id,
            'questions' => $questions,
            'type' => gettype($questions),
        ]);
    
        $answers = [];
        if ($response) {
            $answers = $response->answers;
            if (is_string($answers)) {
                $decodedAnswers = json_decode($answers, true);
                if (is_array($decodedAnswers)) {
                    $answers = $decodedAnswers;
                } else {
                    $answers = array_map('trim', explode(',', $answers));
                }
            }
        }
        
        $answersString = implode(',', array_map(fn($ans) => $ans ?: 'No respondida', $answers));
        
        return view('admin.surveys.user-responses', compact('survey', 'user', 'questions', 'answers', 'answersString'));
    }
    
    /**
     * Verifica si una cadena es un JSON válido
     */
    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function show($id)
    {
        $survey = Survey::find($id);
        if (!$survey) {
            return redirect()->route('surveys.index')->with('error', 'Encuesta no encontrada.');
        }
        return view('surveys.show', compact('survey'));
    }

     
}