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
                    <a href="{{ route('documents.add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar Documento</a>
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
                            <form method="GET" action="{{ route('documents.list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o categoría" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                                <a href="{{ route('documents.list') }}" class="btn btn-secondary mb-2 ml-2">Restablecer</a>
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
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->nombre }}</td>
                                            <td>{{ $value->descripcion }}</td>
                                            <td>{{ $value->categoria_grado }}</td>
                                            <td>{{ $value->categoria_asignatura }}</td>
                                            <td>
                                                @if($value->archivo)
                                                    <a href="{{ route('documents.download', $value->id) }}" class="btn btn-sm btn-info">Descargar Archivo</a>
                                                @else
                                                    No disponible
                                                @endif
                                            </td>
                                            <td>{{ $value->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('documents.edit', $value->id) }}" class="btn btn-sm btn-success">Modificar</a>
                                                <a href="{{ route('documents.delete', $value->id) }}" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este documento?');"
                                                    class="btn btn-sm btn-danger">Eliminar</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
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