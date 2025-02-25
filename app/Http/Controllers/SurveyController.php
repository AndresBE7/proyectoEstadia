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
            // Verificar si el nivel académico de los usuarios es "Secundaria"
            $eligibleUsers = \App\Models\User::where('nivel_academico', 'Secundaria')->get();
    
            if ($eligibleUsers->isEmpty()) {
                return redirect()
                    ->route('admin.surveys.index')
                    ->with('error', 'No hay alumnos de nivel secundario para activar la encuesta.');
            }
    
            // Depuración: Verificar si el objeto Survey tiene los valores correctos
            Log::info("Activando encuesta: ", $survey->toArray());
    
            $survey->update(['is_active' => true]);
            
            return redirect()
                ->route('admin.surveys.index')
                ->with('success', 'Encuesta activada exitosamente.');
                
        } catch (\Exception $e) {
            Log::error("Error al activar la encuesta: " . $e->getMessage());
            
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
        // Obtener el usuario
        $user = \App\Models\User::findOrFail($userId);
    
        // Obtener la respuesta del usuario para esta encuesta
        $response = $survey->responses()
            ->where('user_id', $userId)
            ->first();
    
        // Procesar las preguntas de la encuesta
        $questions = $survey->questions;
        if (is_string($questions)) {
            if ($this->isJson($questions)) {
                $questions = json_decode($questions, true); // Si es JSON, decodificar
            } else {
                $questions = array_map('trim', explode(',', $questions)); // Convertir cadena separada por comas a array
            }
        }
    
        // Procesar las respuestas del usuario
        $answers = [];
        if ($response) {
            $answers = $response->answers;
            if (is_string($answers)) {
                if ($this->isJson($answers)) {
                    $answers = json_decode($answers, true); // Si es JSON, decodificar
                } else {
                    $answers = array_map('trim', explode(',', $answers)); // Convertir cadena separada por comas a array
                }
            }
        }
    
        // Convertimos las respuestas a una cadena separada por comas para la vista
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