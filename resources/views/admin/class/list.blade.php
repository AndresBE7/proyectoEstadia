@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de grupos</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/class/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar grupo</a>
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
                            <h3 class="card-title">Buscar Grupo</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/class/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o ID" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                                <a href="{{ url('admin/class/list') }}" class="btn btn-secondary mb-2 ml-2">Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de administradores -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Grupos</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grado</th>
                                        <th>Grupo </th>
                                        <th>Horario</th>
                                        <th>Nivel Academico</th>
                                        <th>Periodo</th>
                                        <th>Fecha de creación</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($getRecord->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">No se encontraron grupos.</td>
                                        </tr>
                                    @else
                                        @foreach($getRecord as $value)
                                        <tr>
                                            <!-- ID del Grupo -->
                                            <td>{{ $value->id }}</td>
                                            <!-- Nombre del Grupo -->
                                            <td>{{ $value->nombre }}</td>
                                            <!-- Grado -->
                                            <td>{{ $value->grado }}</td>
                                            <!-- Horario -->
                                            <td>{{ $value->horario }}</td>
                                            <!-- Nivel Académico -->
                                            <td>{{ $value->nivel_academico }}</td>
                                            <!-- Periodo Escolar -->
                                            <td>{{ $value->periodo_escolar }}</td>
                                            <!-- Fecha de Creación -->
                                            <td>{{ $value->created_at }}</td>
                                            <!-- Acciones -->
                                            <td>
                                                <a href="{{ asset('admin/class/edit/' . $value->id) }}" class="btn btn-sm btn-success">Modificar</a>
                                                <a href="{{ asset('admin/class/delete/' . $value->id) }}" class="btn btn-sm btn-warning">Dar de baja</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                
                                
                                
                            </table>
                            <div style="padding: 10px; float:right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
