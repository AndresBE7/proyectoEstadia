@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar Nuevo Grupo</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row align-items-center w-100">
        <!-- Formulario centrado -->
        <div class="col-md-8 col-lg-12">
          <!-- General form elements -->
          <div class="card card-primary">
            <!-- Form header -->
            <div class="card-header">
              <h3 class="card-title">Registrar</h3>
            </div>

            <!-- Form start -->
            <form method="post" action="{{ url('admin/class/insert') }}">
              {{ csrf_field() }}

              <div class="card-body">
                <!-- Campo Nombre -->
                <div class="form-group">
                  <label for="nombre">Nombre del Grupo</label>
                  <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ingresa el nombre del grupo">
                  @if($errors->has('nombre'))
                    <div style="color: red;">{{ $errors->first('nombre') }}</div>
                  @endif
                </div>

                <!-- Campo Grado -->
                <div class="form-group">
                  <label for="grado">Grupo y Grado</label>
                  <input type="text" name="grado" class="form-control" value="{{ old('grado') }}" placeholder="Ingresa el grado">
                  @if($errors->has('grado'))
                    <div style="color: red;">{{ $errors->first('grado') }}</div>
                  @endif
                </div>

                <!-- Campo Horario -->
                <div class="form-group">
                  <label for="horario">Horario</label>
                  <input type="text" name="horario" class="form-control" value="{{ old('horario') }}" placeholder="Ingresa el horario (por ejemplo, 8:00 AM - 2:00 PM)">
                  @if($errors->has('horario'))
                    <div style="color: red;">{{ $errors->first('horario') }}</div>
                  @endif
                </div>

                <!-- Campo Nivel Académico -->
                <div class="form-group">
                  <label for="nivel_academico">Nivel Académico</label>
                  <input type="text" name="nivel_academico" class="form-control" value="{{ old('nivel_academico') }}" placeholder="Ingresa el nivel académico (por ejemplo, Primaria, Secundaria)">
                  @if($errors->has('nivel_academico'))
                    <div style="color: red;">{{ $errors->first('nivel_academico') }}</div>
                  @endif
                </div>

                <!-- Campo Periodo -->
                <div class="form-group">
                  <label for="periodo">Periodo</label>
                  <input type="text" name="periodo" class="form-control" value="{{ old('periodo') }}" placeholder="Ingresa el periodo (por ejemplo, 2024-2025)">
                  @if($errors->has('periodo'))
                    <div style="color: red;">{{ $errors->first('periodo') }}</div>
                  @endif
                </div>
              </div>

              <!-- Form footer -->
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Registrar Grupo</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
