@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar Nueva Materia</h1>
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
            <form method="post" action="{{ url('admin/subject/insert') }}">
              {{ csrf_field() }}

              <div class="card-body">
                <!-- Campo Nombre -->
                <div class="form-group">
                  <label for="nombre">Nombre de la Materia</label>
                  <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ingresa el nombre de la materia">
                  @if($errors->has('nombre'))
                    <div style="color: red;">{{ $errors->first('nombre') }}</div>
                  @endif
                </div>

                <!-- Campo Descripción -->
                <div class="form-group">
                  <label for="descripcion">Descripción</label>
                  <textarea name="descripcion" class="form-control" rows="3" placeholder="Ingresa una breve descripción de la materia">{{ old('descripcion') }}</textarea>
                  @if($errors->has('descripcion'))
                    <div style="color: red;">{{ $errors->first('descripcion') }}</div>
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

                <!-- Campo Grupos -->
                <div class="form-group">
                  <label for="grupos">Grupos</label>
                  <input type="text" name="grupos" class="form-control" value="{{ old('grupos') }}" placeholder="Ingresa los grupos relacionados (opcional)">
                  @if($errors->has('grupos'))
                    <div style="color: red;">{{ $errors->first('grupos') }}</div>
                  @endif
                </div>
              </div>

              <!-- Form footer -->
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Registrar Materia</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
