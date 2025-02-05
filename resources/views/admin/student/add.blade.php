@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-user-plus"></i> Registrar Nuevo Estudiante</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <!-- Card -->
        <div class="card card-primary shadow">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit"></i> Formulario de Registro</h3>
          </div>

          <!-- Formulario -->
          <form method="post" action="{{ url('admin/student/insert') }}">
            {{ csrf_field() }}

            <div class="card-body">
              <!-- Información Personal -->
              <h5 class="text-primary"><i class="fas fa-id-card"></i> Información Personal</h5>
              <hr>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name"><i class="fas fa-user"></i> Nombre</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ingresa tu nombre completo">
                  @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                  <label for="fecha_nacimiento"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                  @error('fecha_nacimiento') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="curp"><i class="fas fa-address-card"></i> CURP</label>
                  <input type="text" name="curp" class="form-control" value="{{ old('curp') }}" placeholder="Ingresa el CURP">
                  @error('curp') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                  <label for="domicilio"><i class="fas fa-home"></i> Domicilio</label>
                  <textarea name="domicilio" class="form-control" placeholder="Ingresa el domicilio">{{ old('domicilio') }}</textarea>
                  @error('domicilio') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Información Académica -->
              <h5 class="text-primary mt-4"><i class="fas fa-graduation-cap"></i> Información Académica</h5>
              <hr>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="generacion"><i class="fas fa-clock"></i> Generación</label>
                  <input type="text" name="generacion" class="form-control" value="{{ old('generacion') }}" placeholder="Ingresa la generación: 2021 - 2024">
                  @error('generacion') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                  <label for="nivel_academico"><i class="fas fa-book"></i> Nivel Académico</label>
                  <select name="nivel_academico" class="form-control" required>
                    <option value="">Seleccione un nivel académico</option>
                    <option value="Preescolar" {{ old('nivel_academico') == 'Preescolar' ? 'selected' : '' }}>Preescolar</option>
                    <option value="Primaria" {{ old('nivel_academico') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                    <option value="Secundaria" {{ old('nivel_academico') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                  </select>
                  @error('nivel_academico') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="grado"><i class="fas fa-layer-group"></i> Grado y Grupo</label>
                  <input type="text" name="grado" class="form-control" value="{{ old('grado') }}" placeholder="Ingresa el grado: 3A">
                  @error('grado') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Información de Contacto -->
              <h5 class="text-primary mt-4"><i class="fas fa-phone-alt"></i> Información de Contacto</h5>
              <hr>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="medio_contacto"><i class="fas fa-mobile-alt"></i> Contacto de Emergencia</label>
                  <input type="text" name="medio_contacto" class="form-control" value="{{ old('medio_contacto') }}" placeholder="Ingresa el medio de contacto">
                  @error('medio_contacto') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                  <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ingresa tu correo">
                  @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                  @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                  <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                  <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirmar Contraseña">
                  @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Mostrar Contraseñas -->
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="show-passwords">
                  <label class="custom-control-label" for="show-passwords">
                    <i class="fas fa-eye" id="eye-icon"></i> Mostrar contraseñas
                  </label>
                </div>
              </div>

            </div>

            <!-- Botón de envío -->
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Registrar Estudiante</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  document.getElementById('show-passwords').addEventListener('change', function() {
    var password = document.getElementById('password');
    var passwordConfirmation = document.getElementById('password_confirmation');
    var eyeIcon = document.getElementById('eye-icon');
    
    if (this.checked) {
      password.type = 'text';
      passwordConfirmation.type = 'text';
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    } else {
      password.type = 'password';
      passwordConfirmation.type = 'password';
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
  });
</script>
@endsection
