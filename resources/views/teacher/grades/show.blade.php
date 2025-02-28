@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Calificaciones de Alumnos - Grupo: {{ $class->nombre }}</h4>
                    <a href="{{ route('teacher.grades.index') }}" class="btn btn-secondary">Regresar</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($grades->isEmpty())
                        <div class="alert alert-info">
                            No hay calificaciones registradas para este grupo.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Alumno</th>
                                        <th>Materia</th>
                                        <th>Semestre</th>
                                        <th>Periodo</th>
                                        <th>Calificación</th>
                                        <th>Comentarios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grades as $studentId => $studentGrades)
                                        @php
                                            $student = $class->students->find($studentId);
                                        @endphp
                                        @if ($student)
                                            @foreach ($studentGrades as $grade)
                                                <tr>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $grade->subject->nombre }}</td>
                                                    <td>{{ $grade->semester }}</td>
                                                    <td>{{ $grade->period }}</td>
                                                    <td>{{ number_format($grade->grade, 2) }}</td>
                                                    <td>{{ $grade->comments ?? 'Sin comentarios' }}</td>
                                                    <td>
                                                        <a href="{{ route('teacher.grades.edit', $grade->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        <form action="{{ route('teacher.grades.destroy', $grade->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de eliminar esta calificación?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection