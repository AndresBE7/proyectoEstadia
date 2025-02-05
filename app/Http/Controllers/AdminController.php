<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Support\Facades\Notification;


class AdminController extends Controller
{
    public function list(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $data['getRecord'] = User::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                      ->orWhere('id', $search);
            })->get();

            if ($data['getRecord']->isEmpty()) {
                session()->flash('error', 'No se encontraron registros. Verifica tus datos.');
            }
        } else {
            $data['getRecord'] = User::getAdmin();
        }

        $data['header_title'] = "Lista de administradores";
        return view('admin.admin.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Agregar administrador";
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8', // Longitud mínima de 8 caracteres
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[0-9]/', // Al menos un número
                'regex:/[@$!%*?&#]/', // Al menos un carácter especial
            ],
        ], $this->messages());
    
        // Generar una contraseña en texto claro
        $plainPassword = $request->password;
    
        // Crear el usuario
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($plainPassword); // Guardar la contraseña cifrada
        $user->user_type = 1; // Administrador
        $user->save();
    
        // Enviar la notificación con la contraseña en texto plano
        $user->notify(new WelcomeUserNotification($user, $plainPassword));
    
        return redirect('admin/admin/list')->with('success', 'Administrador añadido correctamente');
    }
    
    

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Editar administrador";
            return view('admin.admin.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $user = User::getSingle($id);

        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
        ], $this->messages());

        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Administrador modificado correctamente');
    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Administrador eliminado correctamente');
    }

    private function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no debe exceder los 50 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe proporcionar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una letra minúscula, una letra mayúscula, un número y un carácter especial.',
        ];
    }
}
