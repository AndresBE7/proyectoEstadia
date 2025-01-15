<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ParentController extends Controller
{

    public function list(Request $request)
    {
        $search = $request->get('search');
        
        // Obtener solo estudiantes (user_type = 3) y no eliminados (is_delete = 0)
        $query = User::where('user_type', 4)
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
        return view('admin.parent.list', compact('getRecord'));
    }

    public function add(Request $request)
    {
        $data['header_ttle'] = "Añadir Tutor";
        return view('admin.parent.add', $data);
    }
    
    

    // Función para insertar un nuevo tutor
    public function insert(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'domicilio' => 'required|string|max:255',
            'medio_contacto' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Confirmación de la contraseña
        ]);

        // Crear un nuevo registro de tutor en la base de datos
        $user = new User();
        $user->name = $request->name;
        $user->domicilio = $request->domicilio;
        $user->medio_contacto = $request->medio_contacto;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hashear la contraseña
        // Establecer el tipo de usuario como tutor (user_type = 4)
        $user->user_type = 4;
        // Guardar el nuevo tutor en la base de datos
        $user->save();
        // Redirigir al listado de tutores con un mensaje de éxito
        return redirect()->route('admin.parent.list')->with('success', 'Tutor registrado correctamente');
    }

    public function edit($id){
        // Buscar al tutor por su ID
        $parent = User::findOrFail($id); // Cambiar 'Parent' por el modelo correspondiente

        // Retornar la vista con la información del tutor
        return view('admin.parent.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los campos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'domicilio' => 'required|string|max:500',
            'medio_contacto' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id, // Cambiado 'parents' por 'users'
            'password' => 'nullable|min:6|confirmed', // Validar la contraseña si se actualiza
        ]);
    
        // Buscar al tutor por ID
        $parent = User::findOrFail($id);
    
        // Asignar los nuevos valores al tutor
        $parent->name = trim($request->name);
        $parent->domicilio = trim($request->domicilio);
        $parent->medio_contacto = trim($request->medio_contacto);
        $parent->email = trim($request->email);
    
        // Actualizar la contraseña solo si se ingresa una nueva
        if ($request->password) {
            $parent->password = Hash::make($request->password); // Usar Hash::make en lugar de bcrypt
        }
    
        // Guardar los cambios
        $parent->save();
    
        // Redirigir a la lista de tutores con un mensaje de éxito
        return redirect()->route('admin.parent.list')->with('success', 'Tutor actualizado correctamente');
    }
    

    public function delete($id)
    {
        // Buscar al tutor por ID en el modelo User
        $parent = User::findOrFail($id);
    
        // Marcar como eliminado (eliminación lógica)
        $parent->is_delete = 1;
        $parent->save();
    
        // Redirigir a la lista de tutores con un mensaje de éxito
        return redirect()->route('admin.parent.list')->with('success', 'Tutor eliminado correctamente');
    }

    public function myStudent(Request $request)
    {
        // Consulta para tutores
        $tutoresQuery = User::where('user_type', 4)->where('is_delete', 0); // Solo tutores activos
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $tutoresQuery->where(function ($q) use ($search) {
                $q->where('id', $search) // Buscar por ID exacto
                  ->orWhere('name', 'like', "%{$search}%"); // Buscar por nombre
            });
        }
        
        $data['tutores'] = $tutoresQuery->paginate(10); // Paginar tutores
        
        // Consulta para alumnos
        $data['alumnos'] = User::where('user_type', 3) // Alumnos activos
                               ->where('is_delete', 0)
                               ->paginate(10);
    
        // Si necesitas un tutor específico, obténlo
        $data['parent'] = $request->input('parent_id') 
            ? User::find($request->input('parent_id')) 
            : null;
    
        return view('admin.parent.my_student', $data);
    }
    
    public function assignStudentParent(Request $request, $student_id)
    {
        $request->validate([
            'parent_id' => 'required|exists:users,id',
        ]);
    
        // Lógica para asignar el tutor al estudiante
        $student = User::findOrFail($student_id);
        $parent = User::findOrFail($request->input('parent_id'));
    
        // Asume que tienes una relación o campo para esta asignación
        $student->parent_id = $parent->id;
        $student->save();
    
        return redirect()->back()->with('success', 'Tutor asignado correctamente');
    }
    
    public function myStudentParent()
    {
        $id = Auth::user()->id;
        $data['getRecord'] = User::getMyStudent($id);

        $data['header_title'] = "Lista de mi estudiante";
        return view('parent.my_student', $data);
    }
    
}
