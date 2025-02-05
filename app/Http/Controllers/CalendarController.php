<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    // Mostrar el calendario escolar
    public function school_calendar()
    {
        // Obtener los eventos desde la base de datos
        $events = Event::all();

        // Verificar si el usuario es administrador
        $isAdmin = Auth::user()->user_type === 1;

        // Datos para la vista
        return view('calendar.index', [
            'getRecord' => 'Calendario Escolar',
            'events' => $events,
            'isAdmin' => $isAdmin,
        ]);
    }

    // Guardar un nuevo evento
    public function store_event(Request $request)
    {
        // Verificar permisos
        if (Auth::user()->user_type !== 1) {
            return redirect()->route('calendar.index')->with('error', 'No tienes permisos para agregar un evento.');
        }
    
        // Validar los datos del evento
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'all_day' => 'required|boolean',
        ]);
    
        // Crear el evento
        Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'all_day' => $request->all_day,
        ]);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('calendar.index')->with('success', 'Evento creado exitosamente.');
    }


    public function delete_event($id)
    {
        // Buscar el evento por ID
        $event = Event::find($id);
    
        // Verificar si el evento existe
        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado.'], 404);
        }
    
        // Eliminar el evento
        $event->delete();
    
        // Responder con un mensaje de éxito
        return response()->json(['message' => 'Evento eliminado correctamente.'], 200);
    }

}
