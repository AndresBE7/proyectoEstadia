<?php

namespace App\Models;
use App\Models\SubjectModel;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades'; // Asegúrate de que el nombre de la tabla sea correcto
    protected $fillable = [
        'student_id', 'class_id', 'teacher_id', 'subject_id', 'semester', 'period', 'grade', 'comments'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }
}