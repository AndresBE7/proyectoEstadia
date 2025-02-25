<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event; // Asegúrate de que este sea el modelo correcto

class CalendarController extends Controller
{
    // Mostrar el calendario escolar
    public function school_calendar()
    {
        $events = Event::all();
        $isAdmin = Auth::user()->user_type === 1;

        return view('calendar.index', [
            'getRecord' => 'Calendario Escolar',
            'events' => $events,
            'isAdmin' => $isAdmin,
        ]);
    }

    // Guardar un nuevo evento
    public function store_event(Request $request)
    {
        if (Auth::user()->user_type !== 1) {
            return redirect()->route('calendar.index')->with('error', 'No tienes permisos para agregar un evento.');
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'all_day' => 'required|boolean',
        ]);
    
        Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'all_day' => $request->all_day,
        ]);
    
        return redirect()->route('calendar.index')->with('success', 'Evento creado exitosamente.');
    }

    // Eliminar un evento
    public function delete_event($id)
    {
        $event = Event::find($id); // Usamos Event en lugar de CalendarModel
    
        if (!$event) {
            return response()->json([
                'message' => 'Evento no encontrado',
            ], 404);
        }
    
        $event->delete();
    
        return response()->json([
            'message' => 'Evento eliminado con éxito',
        ], 200);
    }
}