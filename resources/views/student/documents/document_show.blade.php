@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mis Documentos</h1>
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
                            <h3 class="card-title">Buscar Documentos</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('student/documents/show') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o asignatura" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                                <a href="{{ url('student/documents/show') }}" class="btn btn-secondary mb-2 ml-2">Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de documentos -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Documentos Disponibles</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Categoría (Grado)</th>
                                        <th>Categoría (Asignatura)</th>
                                        <th>Archivo</th>
                                        <th>Fecha de Subida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($documents->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">No se encontraron documentos.</td>
                                        </tr>
                                    @else
                                        @foreach($documents as $document)
                                        <tr>
                                            <td>{{ $document->nombre }}</td>
                                            <td>{{ $document->descripcion }}</td>
                                            <td>{{ $document->categoria_grado }}</td>
                                            <td>{{ $document->categoria_asignatura }}</td>
                                            <td>
                                                @if($document->archivo)
                                                <a href="{{ route('student.documents.download', $document->id) }}" class="btn btn-sm btn-info">Descargar</a>                                                @else
                                                    No disponible
                                                @endif
                                            </td>
                                            <td>{{ $document->created_at->format('d-m-Y') }}</td>
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