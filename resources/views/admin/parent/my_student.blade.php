@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-primary">Relación Tutores - Alumnos</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_messages')

                    <!-- Formulario de búsqueda -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <form action="{{ url('admin/parent/my_student') }}" method="GET" class="row g-3 align-items-center">
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        class="form-control" 
                                        placeholder="Buscar por ID o Nombre (Tutores)"
                                        value="{{ request('search') }}"
                                    >
                                </div>
                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> Buscar Tutores
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de Alumnos -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white rounded-top">
                            <h3 class="card-title">Lista de Alumnos</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Grupo</th>
                                        <th>Generación</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alumnos as $alumno)
                                    <tr>
                                        <td>{{ $alumno->id }}</td>
                                        <td>{{ $alumno->name }}</td>
                                        <td>{{ $alumno->email }}</td>
                                        <td>{{ $alumno->grupo_id }}</td>
                                        <td>{{ $alumno->generacion }}</td>
                                        <td>
                                            <!-- Formulario para asignar tutor -->
                                            <form action="{{ route('admin.parent.AssignStudentParent', ['student_id' => $alumno->id]) }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                                                <select name="parent_id" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Seleccionar tutor</option>
                                                    @foreach ($tutores as $tutor)
                                                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Tabla de Tutores -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h3 class="card-title">Lista de Tutores</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo Electrónico</th>
                                        <th>Número de Contacto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tutores as $tutor)
                                    <tr>
                                        <td>{{ $tutor->id }}</td>
                                        <td>{{ $tutor->name }}</td>
                                        <td>{{ $tutor->email }}</td>
                                        <td>{{ $tutor->contact_number }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No se encontraron tutores</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tutores->appends(['search' => request('search')])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
