<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'subject';

    static public function getSingle($id){
        return self::find($id);
    }

    // Obtener los registros de la tabla 'subject'
    public static function getRecord()
    {
        $return = SubjectModel::select(
            'id', // ID único de la materia
            'nombre', // Nombre de la materia
            'descripcion', // Descripción de la materia
            'nivel_academico', // Nivel académico
            'grupos', // Grupos asignados
            'created_at', // Fecha de creación
            'updated_at' // Fecha de actualización
        )->get(); // Obtener todos los registros

        return $return;
    }

    static public function getSubject() {
        $return = SubjectModel::select('subject.*')
            ->orderBy('subject.nombre', 'asc')
            ->get();
    
        return $return;
    }
    
}
