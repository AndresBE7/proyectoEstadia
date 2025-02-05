@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-chalkboard-teacher"></i> Registrar Nuevo Maestro</h1>
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
          <form action="{{ route('admin.teacher.insert') }}" method="POST">
            @csrf

            <div class="card-body">
              <!-- Información Personal -->
              <h5 class="text-primary"><i class="fas fa-id-card"></i> Información Personal</h5>
              <hr>
              <div class="row">
                <!-- Nombre -->
                <div class="form-group col-md-6">
                  <label for="name"><i class="fas fa-user"></i> Nombre</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Email -->
                <div class="form-group col-md-6">
                  <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <hr>

              <!-- Contraseña -->
              <h5 class="text-primary mt-4"><i class="fas fa-lock"></i> Información de Acceso</h5>
              <hr>
              <div class="row">
                <!-- Contraseña -->
                <div class="form-group col-md-6">
                  <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                  <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    <div class="input-group-append">
                      <span class="input-group-text" id="togglePassword"><i class="fas fa-eye"></i></span>
                    </div>
                  </div>
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group col-md-6">
                  <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                  <div class="input-group">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                    <div class="input-group-append">
                      <span class="input-group-text" id="togglePasswordConfirmation"><i class="fas fa-eye"></i></span>
                    </div>
                  </div>
                  @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <hr>

              <!-- CURP y RFC -->
              <h5 class="text-primary mt-4"><i class="fas fa-id-card-alt"></i> Información Adicional</h5>
              <hr>
              <div class="row">
                <!-- CURP -->
                <div class="form-group col-md-6">
                  <label for="curp"><i class="fas fa-id-card"></i> CURP</label>
                  <input type="text" class="form-control @error('curp') is-invalid @enderror" id="curp" name="curp" value="{{ old('curp') }}" required>
                  @error('curp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- RFC -->
                <div class="form-group col-md-6">
                  <label for="rfc"><i class="fas fa-id-card"></i> RFC</label>
                  <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ old('rfc') }}" required>
                  @error('rfc')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <hr>

              <!-- Asignatura y Medio de Contacto -->
              <h5 class="text-primary mt-4"><i class="fas fa-book"></i> Asignatura y Contacto</h5>
              <hr>
              <div class="row">
              <!-- Tipo de maestro -->
              <div class="form-group col-md-6">
                <label for="tipo_maestro"><i class="fas fa-chalkboard-teacher"></i> Tipo de Maestro</label>
                <select class="form-control @error('tipo_maestro') is-invalid @enderror" id="tipo_maestro" name="tipo_maestro" required>
                    <option value="" disabled selected>Seleccione un tipo</option>
                    <option value="Profesor de tiempo completo" {{ old('tipo_maestro') == 'Profesor de tiempo completo' ? 'selected' : '' }}>Profesor de tiempo completo</option>
                    <option value="Profesor de medio tiempo" {{ old('tipo_maestro') == 'Profesor de medio tiempo' ? 'selected' : '' }}>Profesor de medio tiempo</option>
                    <option value="Profesor de asignatura" {{ old('tipo_maestro') == 'Profesor de asignatura' ? 'selected' : '' }}>Profesor de asignatura</option>
                </select>
                @error('tipo_maestro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


                <!-- Medio de Contacto -->
                <div class="form-group col-md-6">
                  <label for="medio_contacto"><i class="fas fa-mobile-alt"></i> Medio de Contacto</label>
                  <input type="text" class="form-control @error('medio_contacto') is-invalid @enderror" id="medio_contacto" name="medio_contacto" value="{{ old('medio_contacto') }}" required>
                  @error('medio_contacto')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>

            <!-- Botón de Registro -->
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Registrar Maestro</button>
              <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Script para alternar visibilidad de la contraseña -->
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const icon = this.querySelector('i');
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      passwordField.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });

  document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
    const passwordConfirmationField = document.getElementById('password_confirmation');
    const icon = this.querySelector('i');
    if (passwordConfirmationField.type === 'password') {
      passwordConfirmationField.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      passwordConfirmationField.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });
</script>

@endsection
