@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar Nuevo Documento</h1>
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
              <h3 class="card-title">Registrar Documento</h3>
            </div>

            <!-- Form start -->
            <form method="post" action="{{ url('admin/documents/insert') }}" enctype="multipart/form-data">
              {{ csrf_field() }}

              <div class="card-body">
                <!-- Campo Nombre -->
                <div class="form-group">
                  <label for="nombre">Nombre del Documento</label>
                  <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ingresa el nombre del documento">
                  @if($errors->has('nombre'))
                    <div style="color: red;">{{ $errors->first('nombre') }}</div>
                  @endif
                </div>

                <!-- Campo Descripción -->
                <div class="form-group">
                  <label for="descripcion">Descripción</label>
                  <textarea name="descripcion" class="form-control" rows="3" placeholder="Ingresa una breve descripción del documento">{{ old('descripcion') }}</textarea>
                  @if($errors->has('descripcion'))
                    <div style="color: red;">{{ $errors->first('descripcion') }}</div>
                  @endif
                </div>

                <!-- Campo Categoría (Grado) -->
                <div class="form-group">
                  <label for="categoria_grado">Categoría del Grado</label>
                  <input type="text" name="categoria_grado" class="form-control" value="{{ old('categoria_grado') }}" placeholder="Ingresa la categoría del grado">
                  @if($errors->has('categoria_grado'))
                    <div style="color: red;">{{ $errors->first('categoria_grado') }}</div>
                  @endif
                </div>

                <!-- Campo Categoría Asignatura -->
                <div class="form-group">
                  <label for="categoria_asignatura">Categoría de la Asignatura</label>
                  <input type="text" name="categoria_asignatura" class="form-control" value="{{ old('categoria_asignatura') }}" placeholder="Ingresa la categoría de la asignatura">
                  @if($errors->has('categoria_asignatura'))
                    <div style="color: red;">{{ $errors->first('categoria_asignatura') }}</div>
                  @endif
                </div>

                <!-- Campo Archivo -->
                <div class="form-group">
                  <label for="archivo">Archivo</label>
                  <input type="file" name="archivo" class="form-control" value="{{ old('archivo') }}">
                  @if($errors->has('archivo'))
                    <div style="color: red;">{{ $errors->first('archivo') }}</div>
                  @endif
                </div>
              </div>

              <!-- Form footer -->
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Registrar Documento</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
