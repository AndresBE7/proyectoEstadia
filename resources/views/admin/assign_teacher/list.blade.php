@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asignar maestros</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ asset('admin/assign_teacher/add') }}" class="btn btn-primary" style="margin-right: 10px;">Agregar asignación</a>
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Asignación de maestros</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del grupo</th>
                                        <th>Nombre del maestro</th>
                                        <th>Email del maestro</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($getRecord->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">No se encontraron asignaciones.</td>
                                        </tr>
                                    @else
                                        @foreach($getRecord as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->class_name }}</td>
                                            <td>{{ $value->teacher_name }}</td>
                                            <td>{{ $value->teacher_email }}</td>
                                            <td>
                                                @if ($value->status == 0)
                                                    Active
                                                @else
                                                    Inactive          
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset('admin/assign_teacher/edit/' . $value->id) }}" class="btn btn-sm btn-success">Modificar</a>
                                                <form action="{{ url('admin/assign_teacher/delete/' . $value->id) }}" method="POST" style="display:inline-block;">
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