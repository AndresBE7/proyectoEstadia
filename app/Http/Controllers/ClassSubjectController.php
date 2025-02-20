<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Support\Facades\Auth;

class ClassSubjectController extends Controller
{
    public function list(Request $request){
        $data['getRecord'] = ClassSubjectModel::getRecord();
        $data['header_title'] = 'Lista de materias';

        return view('admin.assign_subject.list', $data);
    }

    public function add(Request $request){
        $data['header_title'] = 'Añadir asignación de materia';
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        return view('admin.assign_subject.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'subject_id' => 'required|array|min:1',
            'status' => 'required|in:0,1',
        ]);
    
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
        
                if (empty($getAlreadyFirst)) {
                    // Si no existe, crea un nuevo registro
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                } else {
                    // Si ya existe, actualiza el estado
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
            }
            return redirect('admin/assign_subject/list')->with('success', "Materia(s) asignada(s) correctamente");
        }
    
        return redirect('admin/assign_subject/list')->with('error', "No se seleccionaron materias para asignar");
    }
    
    public function delete($id){
        $save = ClassSubjectModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', 'Eliminicación hecha correctamente');
    }

    public function edit($id)
    {
        $getRecord = ClassSubjectModel::getSingle($id);
    
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectId'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = "Edición relación";
    
            return view('admin.assign_subject.edit', $data);
        } else {
            abort(404);
        }
    }
    

    public function update(Request $request)
    {

        $request->validate([
            'class_id' => 'required|exists:class,id',  // Asegura que el grupo esté seleccionado y exista
            'subject_id' => 'required|array|min:1',  // Asegura que se seleccionen al menos una materia
            'status' => 'required|in:0,1',  // Asegura que el status esté entre 0 y 1
        ]);
        if (!empty($request->class_id) && !empty($request->subject_id)) {
        
            foreach ($request->subject_id as $subject_id) {
                // Encuentra el registro existente para la clase y materia seleccionada
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
    
                if ($getAlreadyFirst) {
                    // Si el registro existe, actualiza el estado
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();  // Guarda el cambio en la base de datos
                } else {
                    // Si no existe el registro, crea un nuevo registro
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();  // Guarda el nuevo registro
                }
            }
    
            return redirect('admin/assign_subject/list')->with('success', 'Actualización hecha correctamente');
        }
    
        return redirect()->back()->with('error', 'No se seleccionaron materias para actualizar');
    }
    
    
}