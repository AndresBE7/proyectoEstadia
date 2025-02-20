<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function list(Request $request){
        $search = $request->get('search');

        // Si hay un término de búsqueda, aplicamos un filtro
        if ($search) {
            $getRecord = SubjectModel::where('nombre', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Si no hay búsqueda, mostramos todos los registros
            $getRecord = SubjectModel::all();
        }
    
        return view('admin.subject.list', compact('getRecord'));
    }

    public function add(){
        $data ['header_title'] = "Añadir materia";
        return view('admin.subject.add', $data);
    }


    public function insert(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255|unique:subject,nombre', // Validación única
            'descripcion' => 'nullable|string|max:1000',
            'nivel_academico' => 'required|string|max:255',
            'grupos' => 'nullable|string|max:255',
        ]);
    
        // Verificar si ya existe un grupo con el mismo nombre
        $existingGroup = SubjectModel::where('nombre', $request->nombre)->first();
        if ($existingGroup) {
            return redirect()->back()->with('error', 'El nombre del grupo ya está en uso.')->withInput();
        }
    
        $save = new SubjectModel;
        $save->nombre = $request->nombre;
        $save->descripcion = $request->descripcion;
        $save->nivel_academico = $request->nivel_academico;
        $save->grupos = $request->grupos;
        $save->save();
    
        return redirect('admin/subject/list')->with('success', 'Materia creada correctamente');
    }

    public function edit($id){
        $data['getRecord'] = SubjectModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data ['header_title'] = "Editar materia";
            return view('admin.subject.edit', $data);
        }else{
            abort (400);  // Esto es un error 400 si no se encuentra la materia.
        }
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255|unique:subject,nombre,' . $id, // Validación única excluyendo el registro actual
            'descripcion' => 'nullable|string|max:1000',
            'nivel_academico' => 'required|string|max:255',
            'grupos' => 'nullable|string|max:255',
        ]);
    
        // Buscar el registro de la materia a editar
        $subject = SubjectModel::find($id);
    
        if (!$subject) {
            return redirect('admin/subject/list')->with('error', 'Materia no encontrada');
        }
    
        // Verificar si ya existe otro grupo con el mismo nombre (excluyendo el actual)
        $existingGroup = SubjectModel::where('nombre', $request->nombre)->where('id', '!=', $id)->first();
        if ($existingGroup) {
            return redirect()->back()->with('error', 'El nombre del grupo ya está en uso.')->withInput();
        }
    
        // Actualizar los campos con los nuevos datos del formulario
        $subject->nombre = $request->nombre;
        $subject->descripcion = $request->descripcion;
        $subject->nivel_academico = $request->nivel_academico;
        $subject->grupos = $request->grupos;
    
        // Guardar los cambios
        $subject->save();
    
        // Redirigir a la lista con mensaje de éxito
        return redirect('admin/subject/list')->with('success', 'Materia actualizada correctamente');
    }

    public function delete($id)
    {
        // Buscar el grupo por su ID
        $record = SubjectModel::find($id);
    
        // Verificar si el grupo existe
        if ($record) {
            // Eliminar el grupo
            $record->delete();
            // Redirigir con mensaje de éxito
            return redirect()->back()->with('success', 'Materia eliminado correctamente.');
        } else {
            // Si el grupo no se encuentra, redirigir con mensaje de error
            return redirect()->back()->with('error', 'La materia no existe.');
        }
    }
}
