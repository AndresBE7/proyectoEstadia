@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Asignar Calificación - Grupo: {{ $class->nombre }}</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="gradeForm" action="{{ route('teacher.grades.store', $class->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Estudiante</label>
                            <select name="student_id" id="student_id" class="form-control" required>
                                @foreach ($class->students as $student)
                                    <option value="{{ $student->id }}" data-exists="{{ json_encode($existingGrades->get($student->id, collect())) }}">
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Selecciona un estudiante sin calificaciones previas para la materia, semestre y periodo.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Materias (Selecciona una o más)</label>
                            <div id="subjectCheckboxes">
                                @foreach($subjects as $subject)
                                    <div>
                                        <label style="font-weight: normal;">
                                            <input type="checkbox" value="{{ $subject->id }}" name="subject_id[]" class="subject-checkbox" {{ in_array($subject->id, old('subject_id', [])) ? 'checked' : '' }}>
                                            {{ $subject->nombre }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('subject_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semestre</label>
                            <select name="semester" id="semester" class="form-control" required>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester }}">{{ $semester }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="period" class="form-label">Periodo Bimestral</label>
                            <select name="period" id="period" class="form-control" required>
                                @foreach ($periods as $period)
                                    <option value="{{ $period }}">{{ $period }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Calificación (0-10)</label>
                            <input type="number" name="grade" id="grade" class="form-control" step="0.01" min="0" max="10" required>
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comentarios</label>
                            <textarea name="comments" id="comments" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Asignar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para filtrar alumnos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateStudentOptions() {
            let selectedSubjects = $('.subject-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            let selectedPeriod = $('#period').val();
            let selectedSemester = $('#semester').val();

            if (selectedSubjects.length > 0 && selectedPeriod && selectedSemester) {
                $('#student_id option').each(function() {
                    let studentId = $(this).val();
                    let hasGrade = false;
                    let existingGrades = $(this).data('exists');

                    selectedSubjects.forEach(subjectId => {
                        // Verificar si existe una calificación para este estudiante, materia, periodo y semestre
                        if (existingGrades) {
                            existingGrades.forEach(grade => {
                                if (grade.subject_id == subjectId && grade.period == selectedPeriod && grade.semester == selectedSemester) {
                                    hasGrade = true;
                                }
                            });
                        }
                    });

                    if (hasGrade) {
                        $(this).hide(); // Oculta al alumno si ya tiene calificación
                    } else {
                        $(this).show(); // Muestra al alumno si no tiene calificación
                    }
                });

                // Asegúrate de que haya al menos una opción visible
                if ($('#student_id option:visible').length === 0) {
                    alert('No hay estudiantes disponibles para asignar calificaciones con las materias, semestre y periodo seleccionados.');
                    $('#student_id').prop('disabled', true);
                } else {
                    $('#student_id').prop('disabled', false);
                }
            } else {
                $('#student_id option').show(); // Muestra todos si no hay materias, semestre o periodo seleccionado
                $('#student_id').prop('disabled', false);
            }
        }

        // Escuchar cambios en los checkboxes de materias, y los selects de periodo y semestre
        $('.subject-checkbox, #period, #semester').change(updateStudentOptions);

        // Inicializar al cargar
        updateStudentOptions();
    });
</script>
@endsection