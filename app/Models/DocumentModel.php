<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'documents';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'categoria',
        'fecha_publicacion',
    ];

    // Método para obtener un único registro por ID
    public static function getSingle($id)
    {
        return self::find($id); // Encuentra el documento por su ID
    }

    // Método para obtener todos los registros de la tabla 'documents'
    public static function getRecord()
    {
        $return = self::select(
            'id', // ID único del documento
            'titulo', // Título del documento
            'descripcion', // Descripción breve
            'archivo', // Nombre del archivo
            'categoria', // Categoría del documento
            'fecha_publicacion', // Fecha de publicación
            'created_at', // Fecha de creación
            'updated_at' // Fecha de actualización
        )->get(); // Obtener todos los registros

        return $return;
    }
}
