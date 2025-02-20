<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function list(Request $request){
        $search = $request->get('search');
    
        // Si hay un término de búsqueda, aplicamos un filtro
        if ($search) {
            $getRecord = ClassModel::where('nombre', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->orWhere('periodo_escolar', 'like', '%' . $search . '%') // Búsqueda por generación
                ->get();
        } else {
            // Si no hay búsqueda, mostramos todos los registros
            $getRecord = ClassModel::all();
        }
    
        return view('admin.class.list', compact('getRecord'));
    }
    

    // Modificar el método add
    public function add()
    {
        $data['header_title'] = "Añadir grupo";
        // Obtener todos los estudiantes activos (status = 0)
        $data['students'] = User::where('user_type', 3)->where('is_delete', 0)->get(); 
        return view('admin.class.add', $data);
    }

    // Modificar el método insert
    public function insert(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'grado' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'nivel_academico' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'students' => 'nullable|array', // Validar que students sea un array
            'students.*' => 'exists:users,id,is_delete,0', // Validar que cada ID de estudiante exista y esté activo (status = 0)
        ]);

        $save = new ClassModel;
        $save->nombre = $request->nombre;
        $save->grado = $request->grado;
        $save->horario = $request->horario;
        $save->nivel_academico = $request->nivel_academico;
        $save->periodo_escolar = $request->periodo;
        $save->save();

        // Sincronizar estudiantes seleccionados con el grupo
        if ($request->has('students')) {
            $save->students()->attach($request->students);
        }

        return redirect('admin/class/list')->with('success', 'Grupo creado correctamente');
    }

    public function edit($id)
    {
        $data['getRecord'] = ClassModel::find($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Editar grupo";
            // Obtener todos los estudiantes activos (status = 0)
            $data['students'] = User::where('user_type', 3)->where('is_delete', 0)->get(); 
            $data['selectedStudents'] = $data['getRecord']->students->pluck('id')->toArray(); // Obtener los IDs de los estudiantes ya asignados
            return view('admin.class.edit', $data);
        } else {
            abort(400);  // Esto es un error 400 si no se encuentra el grupo.
        }
    }
    
    public function update($id, Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'grado' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'nivel_academico' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'students' => 'nullable|array',
            'students.*' => 'exists:users,id,is_delete,0', // Validar que los estudiantes estén activos (status = 0)
        ]);

        // Buscar el registro existente
        $record = ClassModel::find($id);

        // Verificar si el registro existe
        if (!$record) {
            return redirect('admin/class/list')->with('error', 'El grupo no existe.');
        }

        // Actualizar los datos
        $record->nombre = $request->nombre;
        $record->grado = $request->grado;
        $record->horario = $request->horario;
        $record->nivel_academico = $request->nivel_academico;
        $record->periodo_escolar = $request->periodo;
        $record->save();

        // Sincronizar estudiantes
        if ($request->has('students')) {
            $record->students()->sync($request->students);
        } else {
            $record->students()->detach(); // Eliminar todas las asignaciones si no se seleccionaron estudiantes
        }

        return redirect('admin/class/list')->with('success', 'Grupo actualizado correctamente.');
    }
    
    public function delete($id)
    {
        // Buscar el grupo por su ID
        $record = ClassModel::find($id);
    
        // Verificar si el grupo existe
        if ($record) {
            // Eliminar el grupo
            $record->delete();
    
            // Redirigir con mensaje de éxito
            return redirect()->back()->with('success', 'Grupo eliminado correctamente.');
        } else {
            // Si el grupo no se encuentra, redirigir con mensaje de error
            return redirect()->back()->with('error', 'El grupo no existe.');
        }
    }
    
    public function students($id)
    {
        $data['class'] = ClassModel::find($id);
        if(!$data['class']) {
            return redirect('admin/class/list')->with('error', 'El grupo no existe.');
        }
    
        $data['students'] = $data['class']->students;
        $data['header_title'] = "Alumnos en " . $data['class']->nombre;
    
        return view('admin.class.students', $data);
    }
}
