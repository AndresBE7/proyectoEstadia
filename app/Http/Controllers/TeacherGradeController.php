<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\SubjectModel;
use App\Models\Grade;
use Illuminate\Support\Facades\Log;

class TeacherGradeController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();
        $classes = ClassModel::whereHas('teachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with('students')->get();

        Log::info('Clases asignadas al maestro:', ['teacher_id' => $teacherId, 'classes' => $classes->toArray()]);

        return view('teacher.grades.index', compact('classes'));
    }

    public function create($classId)
    {
        $class = ClassModel::with('students', 'subjects')->findOrFail($classId);
        $subjects = SubjectModel::getSubject(); // Todas las materias registradas
        $semesters = ['2025-1', '2025-2'];
        $periods = [1, 2, 3];
    
        // Obtener las calificaciones existentes para este grupo
        $existingGrades = Grade::where('class_id', $classId)
            ->with('student', 'subject')
            ->get()
            ->groupBy(['student_id', 'subject_id', 'period', 'semester']);
    
        Log::info('Materias registradas y calificaciones existentes:', [
            'class_id' => $classId,
            'subjects' => $subjects->pluck('nombre')->toArray(),
            'existing_grades' => $existingGrades->toArray()
        ]);
    
        return view('teacher.grades.create', compact('class', 'subjects', 'semesters', 'periods', 'existingGrades'));
    }

public function store(Request $request, $classId)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:users,id',
        'subject_id' => 'required|array|min:1',
        'subject_id.*' => 'exists:subject,id', // Usamos 'subject' en lugar de 'subjects'
        'semester' => 'required|string',
        'period' => 'required|integer|between:1,3',
        'grade' => 'required|numeric|between:0,10',
        'comments' => 'nullable|string|max:500',
    ]);

    $studentId = $validated['student_id'];
    $semester = $validated['semester'];
    $period = $validated['period'];

    // Verificar si ya existe una calificación para cada materia seleccionada
    foreach ($validated['subject_id'] as $subject_id) {
        $existingGrade = Grade::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('subject_id', $subject_id)
            ->where('semester', $semester)
            ->where('period', $period)
            ->first();

        if ($existingGrade) {
            return redirect()->back()->with('error', 'Ya existe una calificación asignada para este alumno, materia, semestre y periodo.');
        }

        Grade::create([
            'student_id' => $studentId,
            'class_id' => $classId,
            'teacher_id' => auth()->id(),
            'subject_id' => $subject_id,
            'semester' => $semester,
            'period' => $period,
            'grade' => $validated['grade'],
            'comments' => $validated['comments'],
        ]);
    }

    return redirect()->route('teacher.grades.index')->with('success', 'Calificaciones asignadas correctamente');
}

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $class = ClassModel::findOrFail($grade->class_id);
        $subjects = SubjectModel::all();
        $semesters = ['2025-1', '2025-2'];
        $periods = [1, 2, 3];

        return view('teacher.grades.edit', compact('grade', 'class', 'subjects', 'semesters', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'period' => 'required|integer|between:1,3',
            'grade' => 'required|numeric|between:0,10',
            'comments' => 'nullable|string|max:500',
        ]);

        $grade->update($validated);

        return redirect()->route('teacher.grades.index')->with('success', 'Calificación modificada');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('teacher.grades.index')->with('success', 'Calificación eliminada');
    }

    public function showGrades($classId)
    {
        $class = ClassModel::with('students', 'subjects')->findOrFail($classId);
        $teacherId = auth()->id();

        // Verificar que el profesor esté asignado a este grupo
        if (!$class->teachers()->where('teacher_id', $teacherId)->exists()) {
            abort(403, 'No tienes permiso para ver las calificaciones de este grupo.');
        }

        // Obtener las calificaciones de los alumnos del grupo, incluyendo materias y detalles
        $grades = Grade::where('class_id', $classId)
            ->with('student', 'subject')
            ->orderBy('student_id')
            ->orderBy('subject_id')
            ->get()
            ->groupBy('student_id');

        return view('teacher.grades.show', compact('class', 'grades'));
    }
    public function checkGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subject,id',
            'period' => 'required|integer|between:1,3',
            'semester' => 'required|string',
        ]);
    
        $hasGrade = Grade::where('student_id', $request->student_id)
            ->where('subject_id', $request->subject_id)
            ->where('period', $request->period)
            ->where('semester', $request->semester)
            ->exists();
    
        return response()->json(['has_grade' => $hasGrade]);
    }
    
}