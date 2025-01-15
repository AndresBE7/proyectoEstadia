<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

        // Método que obtiene los grupos/clases activos
    static public function getSingle($id){
        return self::find($id);
    }

    static public function getRecord(){
        // Obtener los registros de la tabla 'class' con los datos relacionados de 'users'
        $return = ClassModel::select(
            'class.id', 
            'class.nombre',
            'class.grado',
            'class.horario',
            'class.nivel_academico',
            'class.periodo_escolar',
            'class.created_at as created_at',
            'users.email as user_email'
        )
        ->join('users', 'users.id', '=', 'class.id')// Relación entre las tablas
        ->get(); // se obtienen todos los registros

        return $return;
    }

    static public function getClass() {
        $return = ClassModel::select('class.*')
            ->join('users', 'users.id', '=', 'class.id')// Relación entre las tablas
            ->where('class.is_delete', '=', 0) // Filtro por 'is_delete' para obtener solo las clases no eliminadas
            ->orderBy('class.nombre', 'asc') // Ordenamos por el nombre de la clase
            ->get();
    
        return $return;
    }
    
}
    