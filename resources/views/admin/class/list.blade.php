@extends('layouts.app')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Grupos</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <a href="{{ url('admin/class/add') }}" class="btn btn-primary">Añadir Nuevo Grupo</a>
              </div>
              <div class="card-body p-0">
                <!-- Búsqueda -->
                <div class="p-3">
                  <form action="" method="GET">
                    <div class="input-group">
                      <input type="text" name="search" value="{{ Request::get('search') }}" class="form-control" placeholder="Buscar...">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                      </div>
                    </div>
                  </form>
                </div>

                <!-- Tabla de Grupos -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Grado</th>
                      <th>Horario</th>
                      <th>Nivel Académico</th>
                      <th>Periodo</th>
                      <th>Alumnos</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->nombre }}</td>
                        <td>{{ $value->grado }}</td>
                        <td>{{ $value->horario }}</td>
                        <td>{{ $value->nivel_academico }}</td>
                        <td>{{ $value->periodo_escolar }}</td>
                        <td>{{ $value->students->count() }}</td>
                        <td>
                          <a href="{{ url('admin/class/edit/'.$value->id) }}" class="btn btn-primary btn-sm">Editar</a>
                          <a href="{{ url('admin/class/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de querer eliminar este grupo?')">Eliminar</a>
                          <a href="{{ url('admin/class/students/'.$value->id) }}" class="btn btn-info btn-sm">Ver Alumnos</a>
                        </td>
                      </tr>
                    @endforeach
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