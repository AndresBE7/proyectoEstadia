<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTeacherModel extends Model
{
    protected $table = 'class_teacher';

    // Configurar los nombres de las columnas de timestamps
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    static public function getRecord()
    {
        return self::select(
                'class_teacher.*', 
                'class.nombre as class_name', 
                'users.name as teacher_name', 
                'users.email as teacher_email',
                'creator.name as created_by_name'
            )
            ->join('class', 'class.id', '=', 'class_teacher.class_id')
            ->join('users', 'users.id', '=', 'class_teacher.teacher_id')
            ->join('users as creator', 'creator.id', '=', 'class_teacher.created_by')
            ->where('class_teacher.is_delete', '=', 0)
            ->orderBy('class_teacher.id', 'asc')
            ->paginate(20);
    }

    static public function getAlreadyFirst($class_id, $teacher_id)
    {
        return self::where('class_id', '=', $class_id)
                    ->where('teacher_id', '=', $teacher_id)
                    ->first();
    }

    static public function getAssignTeacherID($class_id)
    {
        return self::where('class_id', '=', $class_id)
                   ->where('is_delete', '=', 0)
                   ->get();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function deleteTeacher($class_id)
    {
        return self::where('class_id', '=', $class_id)->delete();
    }
}