<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // ID del estudiante
            $table->unsignedBigInteger('class_id');   // ID del grupo
            $table->unsignedBigInteger('teacher_id'); // ID del profesor
            $table->unsignedBigInteger('subject_id'); // ID de la materia
            $table->string('semester');               // Semestre (ej. "2025-1")
            $table->integer('period');                // Periodo bimestral (1, 2, 3)
            $table->decimal('grade', 4, 2);          // Calificación (ej. 8.50)
            $table->text('comments')->nullable();     // Comentarios adicionales
            $table->timestamps();

            // Relaciones
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('class')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}