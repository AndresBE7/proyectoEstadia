<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth


class DashboardController extends Controller
{
public function dashboard(){
    $data['header_title']='Dashboard';
        if(!empty(Auth::check())){
            return view('admin.dashboard', $data);        
            }elseif(Auth::user()->user_type==2){
            return view('maestro.dashboard', $data);        
            }elseif(Auth::user()->user_type==3){
            return view('alumno.dashboard', $data);        
            }elseif(Auth::user()->user_type==4){
            return view('parent.dashboard', $data);        
            }        
    return view('auth.login'); 

    }
}
