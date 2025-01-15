@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Estudiantes</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/student/add') }}" class="btn btn-primary" style="margin-right: 10px;">
                        <i class="fas fa-user-plus"></i> Agregar Estudiante
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_messages')

                    @if(session()->has('error'))
                        <div class="alert alert-danger mb-4" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Buscar Estudiante</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/student/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o ID" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Buscar</button>
                                <a href="{{ url('admin/student/list') }}" class="btn btn-secondary mb-2 ml-2"><i class="fas fa-undo"></i> Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de estudiantes -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Estudiantes</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Generación</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Nivel Académico</th>
                                        <th>Grado</th>
                                        <th>Domicilio</th>
                                        <th>CURP</th>
                                        <th>Medio de Contacto</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getRecord as $key => $student)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->generacion }}</td>
                                        <td>{{ $student->fecha_nacimiento }}</td>
                                        <td>{{ $student->nivel_academico }}</td>
                                        <td>{{ $student->grado }}</td>
                                        <td>{{ $student->domicilio }}</td>
                                        <td>{{ $student->curp }}</td>
                                        <td>{{ $student->medio_contacto }}</td>
                                        <td>
                                            @if ($student->is_delete == 0)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Dado de baja</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($student->is_delete == 0)
                                                <div class="btn-group" role="group">
                                                    <a href="{{ asset('admin/student/edit/' . $student->id) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-edit"></i> Modificar
                                                    </a>
                                                    <a href="{{ asset('admin/student/delete/' . $student->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-trash-alt"></i> Dar de baja
                                                    </a>
                                                    <!-- Botón de Enviar mensaje con color verde -->
                                                    <a href="{{ asset('chat?receiver_id=' . base64_encode($student->id)) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-comments"></i> Enviar mensaje
                                                    </a>
                                                </div>
                                            @else
                                                <a href="{{ asset('admin/student/restore/' . $student->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-undo"></i> Restaurar
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="13" class="text-center">No se encontraron resultados</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
