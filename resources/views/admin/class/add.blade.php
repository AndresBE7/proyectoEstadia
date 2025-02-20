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
                  <select name="nivel_academico" class="form-control">
                    <option value="">Selecciona un nivel académico</option>
                    <option value="Preescolar" {{ old('nivel_academico') == 'Preescolar' ? 'selected' : '' }}>Preescolar</option>
                    <option value="Primaria" {{ old('nivel_academico') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                    <option value="Secundaria" {{ old('nivel_academico') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                  </select>
                  @if($errors->has('nivel_academico'))
                    <div style="color: red;">{{ $errors->first('nivel_academico') }}</div>
                  @endif
                </div>


                <!-- Campo Periodo -->
                <div class="form-group">
                  <label for="periodo">Periodo</label>
                  <input type="text" name="periodo" class="form-control" value="{{ old('periodo') }}" placeholder="Ingresa el periodo (por ejemplo, Julio 2024 - Diciembre 2024)">
                  @if($errors->has('periodo'))
                    <div style="color: red;">{{ $errors->first('periodo') }}</div>
                  @endif
                </div>

                <!-- Selección de Alumnos -->
                <div class="form-group">
                  <label for="students">Seleccionar Alumnos</label>
                  <select name="students[]" class="form-control" multiple="multiple" id="students" data-placeholder="Selecciona alumnos">
                    @foreach($students as $student)
                      <option value="{{ $student->id }}">{{ $student->name }} {{ $student->last_name }} ({{ $student->email }})</option>
                    @endforeach
                  </select>
                  @if($errors->has('students'))
                    <div style="color: red;">{{ $errors->first('students') }}</div>
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

@section('scripts')
<!-- Incluyendo las librerías necesarias -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-duallistbox/4.0.0/jquery.bootstrap-duallistbox.min.js"></script>

<script>
  $(document).ready(function() {
    // Inicializar el Dual Listbox
    $('#students').bootstrapDualListbox({
      moveSelectedLabel: 'Seleccionar',
      moveAllLabel: 'Seleccionar todos',
      removeSelectedLabel: 'Quitar',
      removeAllLabel: 'Quitar todos'
    });

    // Inicializar Select2 (si necesitas búsqueda dentro del Dual Listbox)
    $('#students').select2();

    // Establecer la altura mínima autoajustable según la cantidad de elementos
    $('#students').on('change', function() {
      var numberOfOptions = $(this).find('option').length;
      var height = numberOfOptions > 10 ? 300 : 150; // Cambiar el valor de 10 según el número de opciones que quieras mostrar
      $(this).css('min-height', height + 'px');
    });
  });
</script>
@endsection
