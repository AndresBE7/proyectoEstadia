@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-user-plus"></i> Registrar Nuevo Tutor</h1>
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
          <form method="post" action="{{ url('admin/parent/insert') }}">
            {{ csrf_field() }}

            <div class="card-body">
              <!-- Información Personal -->
              <h5 class="text-primary"><i class="fas fa-id-card"></i> Información Personal</h5>
              <hr>
              <div class="row">
                <!-- Nombre -->
                <div class="form-group col-md-6">
                  <label for="name"><i class="fas fa-user"></i> Nombre</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ingresa el nombre completo del tutor">
                  @error('name')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Domicilio -->
                <div class="form-group col-md-6">
                  <label for="domicilio"><i class="fas fa-home"></i> Domicilio</label>
                  <textarea name="domicilio" class="form-control" placeholder="Ingresa el domicilio">{{ old('domicilio') }}</textarea>
                  @error('domicilio')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <hr>

              <!-- Información de Contacto -->
              <h5 class="text-primary mt-4"><i class="fas fa-phone-alt"></i> Información de Contacto</h5>
              <hr>
              <div class="row">
                <!-- Medio de Contacto -->
                <div class="form-group col-md-6">
                  <label for="medio_contacto"><i class="fas fa-mobile-alt"></i> Medio de Contacto</label>
                  <input type="text" name="medio_contacto" class="form-control" value="{{ old('medio_contacto') }}" placeholder="Ingresa el medio de contacto">
                  @error('medio_contacto')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="form-group col-md-6">
                  <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ingresa el correo electrónico">
                  @error('email')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="row">
                <!-- Contraseña -->
                <div class="form-group col-md-6">
                  <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                    <div class="input-group-append">
                      <span class="input-group-text" id="togglePassword"><i class="fas fa-eye"></i></span>
                    </div>
                  </div>
                  @error('password')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Confirmación de Contraseña -->
                <div class="form-group col-md-6">
                  <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                  <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmar Contraseña">
                    <div class="input-group-append">
                      <span class="input-group-text" id="togglePasswordConfirmation"><i class="fas fa-eye"></i></span>
                    </div>
                  </div>
                  @error('password_confirmation')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>
            <!-- Botón de envío -->
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Enviar</button>
              <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

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
