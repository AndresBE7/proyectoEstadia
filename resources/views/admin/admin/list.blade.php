@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Administradores</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/admin/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar Administrador</a>
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
                            <h3 class="card-title">Buscar Administradores</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('admin/admin/list') }}" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Buscar por nombre o ID" 
                                        value="{{ request()->get('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Buscar</button>
                                <a href="{{ url('admin/admin/list') }}" class="btn btn-secondary mb-2 ml-2"><i class="fas fa-undo"></i> Restablecer</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de Administradores -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Administradores</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Fecha de Creación</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getRecord as $key => $admin)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->created_at }}</td>
                                        <td>
                                            @if ($admin->is_delete == 0)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Dado de Baja</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($admin->is_delete == 0)
                                                <div class="btn-group" role="group">
                                                    <a href="{{ asset('admin/admin/edit/' . $admin->id) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-edit"></i> Modificar
                                                    </a>
                                                    <a href="{{ asset('admin/admin/delete/' . $admin->id) }}" class="btn btn-sm btn-warning" onclick="return confirm('¿Está seguro de que desea eliminar este administrador?')">
                                                        <i class="fas fa-trash-alt"></i> Dar de Baja
                                                    </a>
                                                    <a href="{{ asset('chat?receiver_id=' . base64_encode($admin->id)) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-comments"></i> Enviar Mensaje
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No se encontraron resultados</td>
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
