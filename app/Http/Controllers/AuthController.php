<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;// Importa la clase Hash
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
    {
        public function login ()
    {
        if(!empty(Auth::check())){
            if(Auth::user()->user_type==1){
                return redirect('admin/dashboard');        
            }elseif(Auth::user()->user_type==2){
                return redirect('teacher/dashboard');        
            }elseif(Auth::user()->user_type==3){
                return redirect('student/dashboard');        
            }elseif(Auth::user()->user_type==4){
                return redirect('parent/dashboard');        
            }        }
        return view('auth.login'); 
    }
        
    public function AuthLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $remember = $request->has('remember'); // Detectar si se activó "recordar usuario"
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if(Auth::user()->user_type==1){
                return redirect('admin/dashboard');        
            }elseif(Auth::user()->user_type==2){
                return redirect('teacher/dashboard');        
            }elseif(Auth::user()->user_type==3){
                return redirect('student/dashboard');        
            }elseif(Auth::user()->user_type==4){
                return redirect('parent/dashboard');        
            }
            return redirect("admin/dashboard");
        }
    
        return redirect()->back()->withErrors([
            'error' => 'Por favor verifica tu correo y contraseña.',
        ]);
    }

    public function forgotpassword(){
        return view('auth.forgot');
    }

    public function PostForgotPassword(Request $request){
        $User = User::getEmailSingle($request->email);
        if (!empty($User)) {
            $User->remember_token = Str::random(30);
            $User->save();
        
            Mail::to($User->email)->send(new ForgotPasswordMail($User));
        
            return redirect()->back()->with('Hecho!', "Se ha enviado un enlace de recuperación a tu correo");
        } else {
            return redirect()->back()->withErrors([
                'error' => 'Correo no registrado'
            ]);
        }
    }
    


    public function reset($remember_token){
        $User = User::getTokenSingle($remember_token);
        if(!empty($User)){
            $data['User'] = $User;
            return view('auth.reset', $data);
        }
    }

    public function PostReset($token, Request $request){
        if($request->password == $request->password){
            $User = User::getTokenSingle($token);
            $User -> password = Hash::make($request->password);
            $User->remember_token = Str::random(30);
            $User -> save();

            return redirect(asset(''))->with('Hecho!', 'Se ha cambiado correctamente la contraseña');
        }else{
            return redirect()->back()->with('Error', "Verifica que sean la misma contraseña");
        }
    }

    public function logout(){
        Auth::logout();
        return redirect(asset(''));
    }
}
