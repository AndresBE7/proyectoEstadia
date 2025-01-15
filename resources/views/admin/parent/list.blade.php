@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Tutores</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/parent/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar Tutor</a>
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
                        <div class="alert alert-danger mb-4" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Buscar Tutor</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/parent/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o correo" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Buscar</button>
                                <a href="{{ url('admin/parent/list') }}" class="btn btn-secondary mb-2 ml-2"><i class="fas fa-undo"></i> Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de Tutores -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Tutores</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre(s)</th>
                                        <th>Correo Electrónico</th>
                                        <th>Número de Contacto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getRecord as $value)
                                    <tr>
                                        <!-- ID del Tutor -->
                                        <td>{{ $value->id }}</td>
                                        <!-- Nombre(s) -->
                                        <td>{{ $value->name }}</td>
                                        <!-- Correo Electrónico -->
                                        <td>{{ $value->email }}</td>
                                        <!-- Número de Contacto -->
                                        <td>{{ $value->medio_contacto }}</td>
                                        <!-- Acciones -->
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ asset('admin/parent/edit/' . $value->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i> Modificar
                                                </a>
                                                <a href="{{ asset('admin/parent/delete/' . $value->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-trash-alt"></i> Dar de baja
                                                </a>
                                                <a href="{{ asset('admin/parent/my-student/' . $value->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-user-graduate"></i> Mi estudiante
                                                </a>
                                                <a href="{{ asset('chat?receiver_id=' . base64_encode($value->id)) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-comments"></i> Enviar mensaje
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron resultados</td>
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
