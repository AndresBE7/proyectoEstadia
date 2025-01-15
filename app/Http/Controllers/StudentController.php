<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function list(Request $request)
    {
        $search = $request->get('search');
        
        // Obtener solo estudiantes (user_type = 3) y no eliminados (is_delete = 0)
        $query = User::where('user_type', 3)
            ->where('is_delete', 0); // Filtro para usuarios activos
        
        // Si hay un término de búsqueda, aplicamos un filtro adicional
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        // Obtenemos los registros con paginación
        $getRecord = $query->orderBy('id', 'desc')->paginate(20);
        // Retornar la vista con los registros obtenidos
        return view('admin.student.list', compact('getRecord'));
    }

    public function insert(Request $request) {
        // Obtener los registros de las clases con los usuarios relacionados
        $getClass = ClassModel::getRecord();
        // Pasar los registros de las clases a la vista
        $data['getClass'] = $getClass;
        $data['header_ttle'] = "Añadir Estudiante";
    
        // Validación de los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'curp' => 'required|string|max:18', // Validar CURP único
            'domicilio' => 'required|string|max:500',
            'generacion' => 'required|string|max:50',
            'nivel_academico' => 'required|string|max:100',
            'grado' => 'required|string|max:50',
            'medio_contacto' => 'required|string|max:100',
            'email' => 'required|email|unique:users', // Validar que el correo sea único
            'password' => 'required|string|min:8|confirmed', // Confirmación de contraseña
        ]);
        
        // Crear un nuevo estudiante
        $student = new User;
        $student->name = trim($request->name);
        $student->fecha_nacimiento = $request->fecha_nacimiento;
        $student->curp = trim($request->curp);
        $student->domicilio = trim($request->domicilio);
        $student->generacion = trim($request->generacion);
        $student->nivel_academico = trim($request->nivel_academico);
        $student->grado = trim($request->grado);
        $student->medio_contacto = trim($request->medio_contacto);
        $student->email = trim($request->email);
        $student->password = Hash::make($request->password); // Encriptar la contraseña
        $student->user_type = 3; // Asignar el tipo de usuario (3 para estudiante)
        $student->save(); // Guardar el estudiante en la base de datos
        
        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.student.list')->with('success', 'Estudiante registrado correctamente');
    }
    
    public function add(Request $request)
    {
        //$data['header_ttle'] = "Añadir Estudiante";
    
        return view('admin.student.add');
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        $student = User::findOrFail($id); // Asegúrate de que $student esté bien cargado
        return view('admin.student.edit', compact('student'));
    }
    
    // Método para actualizar un estudiante
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'curp' => 'required|string|max:18|unique:users,curp,' . $id, // Validar CURP único excepto el actual
            'domicilio' => 'required|string|max:500',
            'generacion' => 'required|string|max:50',
            'nivel_academico' => 'required|string|max:100',
            'grado' => 'required|string|max:50',
            'medio_contacto' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id, // Validar correo único excepto el actual
        ]);
    
        $student = User::findOrFail($id); // Buscar el estudiante por ID
        $student->name = trim($request->name);
        $student->fecha_nacimiento = $request->fecha_nacimiento;
        $student->curp = trim($request->curp);
        $student->domicilio = trim($request->domicilio);
        $student->generacion = trim($request->generacion);
        $student->nivel_academico = trim($request->nivel_academico);
        $student->grado = trim($request->grado);
        $student->medio_contacto = trim($request->medio_contacto);
        $student->email = trim($request->email);
        $student->save(); // Actualizar los datos
    
        return redirect()->route('admin.student.list')->with('success', 'Estudiante actualizado correctamente');
    }

    // Método para eliminar un estudiante (eliminación lógica)
    public function delete($id)
    {
        $student = User::findOrFail($id); // Buscar el estudiante por ID
        $student->is_delete = 1; // Marcar como eliminado
        $student->save();
    
        return redirect()->route('admin.student.list')->with('success', 'Estudiante eliminado correctamente');
    }
}
