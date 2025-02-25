<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassTeacherModel;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClassTeacherController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = ClassTeacherModel::getRecord();
        $data['header_title'] = 'Lista de asignaciones de maestros';
        return view('admin.assign_teacher.list', $data);
    }

    public function add(Request $request)
    {
        $data['header_title'] = 'Añadir asignación de maestro';
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacher(); // Usamos el método del modelo User para obtener maestros
        return view('admin.assign_teacher.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'teacher_id' => 'required|array|min:1', // Ahora teacher_id es un array para múltiples maestros
            'status' => 'required|in:0,1',
        ]);

        if (!empty($request->teacher_id)) {
            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadyFirst = ClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);

                if (empty($getAlreadyFirst)) {
                    $save = new ClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                } else {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
            }
            return redirect('admin/assign_teacher/list')->with('success', "Maestro(s) asignado(s) correctamente");
        }

        return redirect('admin/assign_teacher/list')->with('error', "No se seleccionaron maestros para asignar");
    }

    public function delete($id)
    {
        $save = ClassTeacherModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', 'Eliminación hecha correctamente');
    }

    public function edit($id)
    {
        $getRecord = ClassTeacherModel::getSingle($id);

        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherId'] = ClassTeacherModel::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacher();
            $data['header_title'] = "Edición relación";

            return view('admin.assign_teacher.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'teacher_id' => 'required|array|min:1',
            'status' => 'required|in:0,1',
        ]);
    
        // Obtener el registro original para conocer el class_id anterior
        $originalRecord = ClassTeacherModel::getSingle($request->id);
        $originalClassId = $originalRecord->class_id;
    
        // Obtener los maestros actualmente asignados al grupo original
        $existingAssignments = ClassTeacherModel::getAssignTeacherID($originalClassId)
            ->pluck('teacher_id')
            ->toArray();
    
        // Nuevos maestros seleccionados en el formulario
        $newTeacherIds = $request->teacher_id;
    
        // Si el class_id cambió, eliminamos las asignaciones antiguas y las movemos al nuevo grupo
        if ($originalClassId != $request->class_id) {
            // Eliminar todas las asignaciones del grupo original
            ClassTeacherModel::where('class_id', $originalClassId)->delete();
    
            // Crear nuevas asignaciones para el nuevo grupo
            foreach ($newTeacherIds as $teacher_id) {
                $save = new ClassTeacherModel;
                $save->class_id = $request->class_id;
                $save->teacher_id = $teacher_id;
                $save->status = $request->status;
                $save->created_by = Auth::user()->id;
                $save->save();
            }
        } else {
            // Caso en que el class_id no cambió: actualizar o eliminar asignaciones
    
            // Maestros a eliminar (estaban asignados pero ya no están seleccionados)
            $teachersToRemove = array_diff($existingAssignments, $newTeacherIds);
            if (!empty($teachersToRemove)) {
                ClassTeacherModel::where('class_id', $request->class_id)
                    ->whereIn('teacher_id', $teachersToRemove)
                    ->delete();
            }
    
            // Maestros a agregar o actualizar
            foreach ($newTeacherIds as $teacher_id) {
                $getAlreadyFirst = ClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
    
                if ($getAlreadyFirst) {
                    // Si ya existe, solo actualiza el estado
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    // Si no existe, crea un nuevo registro
                    $save = new ClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
        }
    
        return redirect('admin/assign_teacher/list')->with('success', 'Actualización hecha correctamente');
    }
}