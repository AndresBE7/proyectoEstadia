@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestión de Calificaciones</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Grupo</th>
                                    <th>Alumnos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td>{{ $class->nombre }}</td>
                                        <td>{{ $class->students->count() }}</td>
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $class->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus"></i> Asignar Calificaciones
                                            </a>
                                            <a href="{{ route('teacher.grades.show', $class->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver Calificaciones
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection