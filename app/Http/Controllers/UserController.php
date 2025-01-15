<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function change_password()
    {
        // Se pasa el título de la página a la vista
        $data['header_title'] = "Cambiar Contraseña";
        return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
        // Obtener el usuario autenticado
        $user = User::find(Auth::user()->id);

        // Verificar si la contraseña anterior es correcta
        if (Hash::check($request->old_password, $user->password)) {
            // Si la contraseña es correcta, actualizar la contraseña
            $user->password = Hash::make($request->new_password);
            $user->save();  // Guardar los cambios en la base de datos

            return redirect()->back()->with('success', "La contraseña se actualizó correctamente");
        } else {
            // Si la contraseña anterior no es correcta, mostrar un mensaje de error
            return redirect()->back()->with('error', "La contraseña anterior no es correcta");
        }
    }
}
