@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Profesores</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.teacher.add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar Nuevo Profesor</a>
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
                            <h3 class="card-title">Buscar Profesores</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/teacher/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar por nombre o ID" 
                                           value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Buscar</button>
                                <a href="{{ url('admin/teacher/list') }}" class="btn btn-secondary mb-2 ml-2"><i class="fas fa-undo"></i> Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de Profesores -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Profesores</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>CURP</th>
                                        <th>RFC</th>
                                        <th>Materia</th>
                                        <th>Contacto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->id }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->curp }}</td>
                                        <td>{{ $teacher->rfc }}</td>
                                        <td>{{ $teacher->asignatura_impartir }}</td>
                                        <td>{{ $teacher->medio_contacto }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.teacher.edit', $teacher->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i> Modificar
                                                </a>
                                                <form action="{{ route('admin.teacher.delete', $teacher->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Está seguro de que desea eliminar este profesor?')">
                                                        <i class="fas fa-trash-alt"></i> Dar de Baja
                                                    </button>
                                                </form>
                                                <a href="{{ asset('chat?receiver_id=' . base64_encode($teacher->id)) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-comments"></i> Enviar Mensaje
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No se encontraron resultados</td>
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
