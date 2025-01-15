@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Documentos</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ url('admin/documents/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar Documento</a>
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
                            <h3 class="card-title">Buscar Documento</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/documents/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o categoría" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                                <a href="{{ url('admin/documents/list') }}" class="btn btn-secondary mb-2 ml-2">Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de documentos -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Documentos</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Categoría (Grado)</th>
                                        <th>Categoría (Asignatura)</th>
                                        <th>Archivo</th>
                                        <th>Fecha de Subida</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($getRecord->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">No se encontraron documentos.</td>
                                        </tr>
                                    @else
                                        @foreach($getRecord as $value)
                                        <tr>
                                            <!-- ID del Documento -->
                                            <td>{{ $value->id }}</td>
                                            <!-- Nombre -->
                                            <td>{{ $value->nombre }}</td>
                                            <!-- Descripción -->
                                            <td>{{ $value->descripcion }}</td>
                                            <!-- Categoría de Grado -->
                                            <td>{{ $value->categoria_grado }}</td>
                                            <!-- Categoría de Asignatura -->
                                            <td>{{ $value->categoria_asignatura }}</td>
                                            <!-- Archivo -->
                                            <td>
                                                @if($value->archivo)
                                                    <a href="{{ url('admin/documents/download/' . $value->id) }}" class="btn btn-sm btn-info">Descargar Archivo</a>
                                                @else
                                                    No disponible
                                                @endif
                                            </td>
                                            
                                            <!-- Fecha de Subida -->
                                            <td>{{ $value->created_at->format('d-m-Y') }}</td>
                                            <!-- Acciones -->
                                            <td>
                                                <a href="{{ url('admin/documents/edit/' . $value->id) }}" class="btn btn-sm btn-success">Modificar</a>
                                                <a href="{{ url('admin/documents/delete/' . $value->id) }}" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este documento?');"
                                                    class="btn btn-sm btn-danger">Eliminar</a>
                                            </td>
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
