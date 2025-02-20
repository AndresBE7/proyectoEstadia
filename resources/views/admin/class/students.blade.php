@extends('layouts.app')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Alumnos en "{{ $class->nombre }}"</h1>
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
                <h3 class="card-title">Listado de alumnos</h3>
                <div class="card-tools">
                  <a href="{{ url('admin/class/edit/'.$class->id) }}" class="btn btn-primary btn-sm">Editar Grupo</a>
                  <a href="{{ url('admin/class/list') }}" class="btn btn-secondary btn-sm">Volver a la lista</a>
                </div>
              </div>
              <div class="card-body p-0">
                @if($students->count() > 0)
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($students as $student)
                        <tr>
                          <td>{{ $student->id }}</td>
                          <td>{{ $student->name }}</td>
                          <td>{{ $student->email }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @else
                  <div class="alert alert-info m-3">
                    No hay alumnos asignados a este grupo.
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection