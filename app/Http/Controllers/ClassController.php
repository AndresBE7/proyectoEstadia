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
            ->get();
    } else {
        // Si no hay búsqueda, mostramos todos los registros
        $getRecord = ClassModel::all();
    }

    return view('admin.class.list', compact('getRecord'));
}


    public function add (){
        $data ['header_title'] = "Añadir grupo";
        return view('admin.class.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'grado' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'nivel_academico' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
        ]);
    
        $save = new ClassModel;
        $save->nombre = $request->nombre;
        $save->grado = $request->grado;
        $save->horario = $request->horario;
        $save->nivel_academico = $request->nivel_academico;
        $save->periodo_escolar = $request->periodo;
        $save->save();
    
        return redirect('admin/class/list')->with('success', 'Grupo creado correctamente');
    }

    public function edit($id){
        $data['getRecord'] = ClassModel::getSingle($id);
        if(!empty($data['getRecord'])){
            $data ['header_title'] = "Editar grupo";
            return view('admin.class.edit', $data);
        }else{
            abort (400);  // Esto es un error 400 si no se encuentra el grupo.
        }
    }
    
    public function update($id, Request $request){
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'grado' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'nivel_academico' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
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
    
    
}
