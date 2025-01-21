<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarModel;
use Carbon\Carbon;


class CalendarController extends Controller
{
    public function school_calendar()
    {
        $events = CalendarModel::all();

        foreach ($events as $event) {
            $event->start = Carbon::parse($event->start)->toIso8601String(); 
            $event->end = Carbon::parse($event->end)->toIso8601String(); 
        }
        return view('calendar.index', $events); 
    }


    public function AddDate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required',
            'end' => 'required',
            'allDay' => 'required',
        ]);

        $save = new CalendarModel;
        $save->title = $request->title;
        $save->start = $request->start;
        $save->end = $request->end;
        $save->allDay = $request->allDay;
        $save->user_id = auth()->user()->id;
        $save->save();


        $events = CalendarModel::all();
        foreach ($events as $event) {
            $event->start = Carbon::parse($event->start)->toIso8601String(); 
            $event->end = Carbon::parse($event->end)->toIso8601String(); 
        }
        return response()->json([
            'events' => $events
            
        ], 200);         
    }

    public function deleteDate($id)
    {
        $delete = CalendarModel::find($id);
        $delete->delete();
        return response()->json([
            'message' => 'Evento eliminado con éxito',
        ], 200);

    }

    public function getAllDate(){
        $events = CalendarModel::all();

        foreach ($events as $event) {
            $event->start = Carbon::parse($event->start)->toIso8601String(); 
            $event->end = Carbon::parse($event->end)->toIso8601String(); 
        }

        return response()->json($events);
    }

}