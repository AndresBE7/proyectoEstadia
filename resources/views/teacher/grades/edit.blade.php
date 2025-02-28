@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Modificar Calificación - Grupo: {{ $class->nombre }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('teacher.grades.update', $grade->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="subject_id" class="form-label">Materia</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $grade->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semestre</label>
                            <select name="semester" id="semester" class="form-control" required>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester }}" {{ $grade->semester == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="period" class="form-label">Periodo Bimestral</label>
                            <select name="period" id="period" class="form-control" required>
                                @foreach ($periods as $period)
                                    <option value="{{ $period }}" {{ $grade->period == $period ? 'selected' : '' }}>{{ $period }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Calificación (0-10)</label>
                            <input type="number" name="grade" id="grade" class="form-control" value="{{ $grade->grade }}" step="0.01" min="0" max="10" required>
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comentarios</label>
                            <textarea name="comments" id="comments" class="form-control" rows="3">{{ $grade->comments }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection