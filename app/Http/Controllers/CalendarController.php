<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function school_calendar()
    {
        $data['getRecord'] = "Calendario Escolar";
        return view('calendar.index', $data); 
    }
}