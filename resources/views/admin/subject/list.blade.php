@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Materias</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/subject/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar Materia</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_messages')

                    <!-- Mensaje de error si no se encuentran resultados -->
                    @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Buscar Materia</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/subject/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o ID" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                                <a href="{{ url('admin/subject/list') }}" class="btn btn-secondary mb-2 ml-2">Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de materias -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Materias</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Nivel Académico</th>
                                        <th>Grupos</th>
                                        <th>Creado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($getRecord->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No se encontraron materias.</td>
                                        </tr>
                                    @else
                                        @foreach($getRecord as $value)
                                        <tr>
                                            <!-- ID de la Materia -->
                                            <td>{{ $value->id }}</td>
                                            <!-- Nombre de la Materia -->
                                            <td>{{ $value->nombre }}</td>
                                            <!-- Descripción -->
                                            <td>{{ $value->descripcion }}</td>
                                            <!-- Nivel Académico -->
                                            <td>{{ $value->nivel_academico }}</td>
                                            <!-- Grupos -->
                                            <td>{{ $value->grupos }}</td>
                                            <!-- Fecha de Creación -->
                                            <td>{{ $value->created_at }}</td>
                                            <!-- Acciones -->
                                            <td>
                                                <a href="{{ asset('admin/subject/edit/' . $value->id) }}" class="btn btn-sm btn-success">Modificar</a>
                                                <a href="{{ asset('admin/subject/delete/' . $value->id) }}" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta materia?');"
                                                    class="btn btn-sm btn-danger">Eliminar</a>                                                                                             </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div style="padding: 10px; float:right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
