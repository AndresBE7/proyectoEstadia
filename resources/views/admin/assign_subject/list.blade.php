@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asignar materias</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/assign_subject/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar asignación</a>
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
                            <h3 class="card-title">Buscar</h3>
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
                            <h3 class="card-title">Asignación de materias</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre de la clase</th>
                                        <th>Nombre de la materia </th>
                                        <th>Estado</th>
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
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->class_name }}</td>
                                            <td>{{ $value->subject_name }}</td>
                                            <td>
                                                @if ($value -> status == 0)
                                                active
                                                @else
                                                Inactive          
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset('admin/assign_subject/edit/' . $value->id) }}" class="btn btn-sm btn-success">Modificar</a>
                                                
                                                <form action="{{ url('admin/assign_subject/delete/' . $value->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Estás seguro de que deseas dar de baja este registro?');">Dar de baja</button>
                                                </form>
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
