@extends('layouts.app')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Documento</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row align-items-center w-100">
        <div class="col-md-8 col-lg-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Editar Documento</h3>
            </div>

            <!-- Form start -->
            <form method="post" action="{{ url('admin/documents/update/' . $getRecord->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <!-- Campo Título -->
                <div class="form-group">
                    <label for="titulo">Título del Documento</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $getRecord->nombre }}" placeholder="Ingresa el título del documento">
                    @if($errors->has('titulo'))
                        <div style="color: red;">{{ $errors->first('titulo') }}</div>
                    @endif
                </div>

                <!-- Campo Descripción -->
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" placeholder="Ingresa una descripción">{{ $getRecord->descripcion }}</textarea>
                    @if($errors->has('descripcion'))
                        <div style="color: red;">{{ $errors->first('descripcion') }}</div>
                    @endif
                </div>

                <!-- Opción para eliminar archivo -->
                @if($getRecord->archivo)
                    <div class="form-group">
                        <label>Archivo Actual:</label>
                        <p>
                            <a href="{{ url('admin/documents/download/' . $getRecord->id) }}" target="_blank">
                                Descargar {{ $getRecord->archivo }}
                            </a>
                        </p>
                        <div class="form-check">
                            <!-- Agrega la directiva old() para recordar si el checkbox fue marcado previamente -->
                            <input class="form-check-input" type="checkbox" name="eliminar_archivo" id="eliminar_archivo" value="1" {{ old('eliminar_archivo') ? 'checked' : ($getRecord->archivo ? 'checked' : '') }}>
                            <label class="form-check-label" for="eliminar_archivo">
                                Eliminar archivo actual
                            </label>
                        </div>
                    </div>
                @endif


                <!-- Subir nuevo archivo -->
                <div class="form-group">
                    <label for="archivo">Subir Nuevo Archivo</label>
                    <input type="file" name="archivo" class="form-control">
                    @if($errors->has('archivo'))
                        <div style="color: red;">{{ $errors->first('archivo') }}</div>
                    @endif
                    <small class="form-text text-muted">
                        Si seleccionas un archivo nuevo, reemplazará el actual.
                    </small>
                </div>

                <!-- Botones de acción -->
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Actualizar Documento</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
                </div>
            </form>
            
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
