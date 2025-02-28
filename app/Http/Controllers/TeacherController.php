<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\WelcomeTeacherNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{
    // Mostrar la lista de profesores
    public function list()
    {
        $teachers = User::where('user_type', 2)->get();
        return view('admin.teacher.list', compact('teachers'));
    }
    
    public function add()
    {
        return view('admin.teacher.add'); // Vista para agregar un profesor
    }

    public function insert(Request $request)
    {
        // Depuración: Loguear los datos enviados
        Log::info('Datos enviados al registrar maestro:', $request->all());

        // Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'curp' => 'required|string|max:18',
            'rfc' => 'required|string|max:13',
            'asignatura_impartir' => 'required|string|in:Profesor de tiempo completo,Profesor de medio tiempo,Profesor de asignatura',
            'medio_contacto' => 'required|string|max:255',
        ]);

        $plainPassword = $validated['password'];

        $teacher = new User();
        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];
        $teacher->password = Hash::make($plainPassword);
        $teacher->curp = $validated['curp'];
        $teacher->rfc = $validated['rfc'];
        $teacher->asignatura_impartir = $validated['asignatura_impartir']; // Usamos este campo para el tipo de maestro
        $teacher->medio_contacto = $validated['medio_contacto'];
        $teacher->user_type = 2;

        try {
            $teacher->save();
            Log::info('Maestro guardado:', ['teacher_id' => $teacher->id]);

            $teacher->notify(new WelcomeTeacherNotification($teacher, $plainPassword));
            Log::info('Notificación enviada al maestro:', ['email' => $teacher->email]);

            return redirect()->route('admin.teacher.list')->with('success', 'Profesor registrado con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al registrar maestro:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error al registrar el maestro. Por favor, intenta de nuevo.');
        }
    }

    // Mostrar el formulario para editar un profesor
    public function edit($id)
    {
        $teacher = User::findOrFail($id); // Buscar el profesor por ID
        return view('admin.teacher.edit', compact('teacher')); // Vista para editar el profesor
    }

    // Actualizar la información del profesor
    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Cambiar 'teachers' por 'users'
            'password' => 'nullable|string|min:8', // La contraseña puede ser opcional al editar
            'curp' => 'required|string|max:18',
            'rfc' => 'required|string|max:13',
            'asignatura_impartir' => 'required|string|max:255',
            'medio_contacto' => 'required|string|max:255',
        ]);
    
        // Buscar y actualizar el profesor
        $teacher = User::findOrFail($id); // Buscar el usuario (profesor) por ID
    
        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];
    
        // Si se ha proporcionado una nueva contraseña, encriptarla
        if (isset($validated['password']) && $validated['password']) {
            $teacher->password = Hash::make($validated['password']);
        }
        
    
        // Actualizar los demás campos
        $teacher->curp = $validated['curp'];
        $teacher->rfc = $validated['rfc'];
        $teacher->asignatura_impartir = $validated['asignatura_impartir'];
        $teacher->medio_contacto = $validated['medio_contacto'];
    
        $teacher->save(); // Guardar los cambios en la base de datos
    
        return redirect()->route('admin.teacher.list')->with('success', 'Profesor actualizado con éxito!');
    }
    

    // Eliminar un profesor
    public function delete($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->delete(); // Eliminar el profesor de la base de datos

        return redirect()->route('admin.teacher.list')->with('success', 'Profesor eliminado con éxito!');
    }
}
