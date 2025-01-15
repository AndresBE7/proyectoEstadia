@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-user-plus"></i> Registrar Nuevo Maestro</h1>
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
          <form method="POST" action="{{ route('admin.teacher.insert') }}">
            @csrf

            <div class="card-body">
              
              <!-- Información Básica -->
              <h5 class="text-primary"><i class="fas fa-id-card"></i> Información Básica</h5>
              <hr>
              <div class="row">
                <!-- Nombre -->
                <div class="form-group col-md-4">
                  <label for="name"><i class="fas fa-user"></i> Nombre</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ingresa el nombre completo">
                  @error('name')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <!-- CURP -->
                <div class="form-group col-md-4">
                  <label for="curp"><i class="fas fa-address-card"></i> CURP</label>
                  <input type="text" name="curp" class="form-control" value="{{ old('curp') }}" placeholder="Ingresa el CURP">
                  @error('curp')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <!-- RFC -->
                <div class="form-group col-md-4">
                  <label for="rfc"><i class="fas fa-address-card"></i> RFC</label>
                  <input type="text" name="rfc" class="form-control" value="{{ old('rfc') }}" placeholder="Ingresa el RFC">
                  @error('rfc')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Medio de Contacto -->
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="medio_contacto"><i class="fas fa-phone-alt"></i> Medio de Contacto</label>
                  <input type="text" name="medio_contacto" class="form-control" value="{{ old('medio_contacto') }}" placeholder="Ingresa el medio de contacto">
                  @error('medio_contacto')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Información Escolar -->
              <h5 class="text-primary"><i class="fas fa-book"></i> Información Escolar</h5>
              <hr>
              <div class="row">
                <!-- Asignatura a Imprimir -->
                <div class="form-group col-md-6">
                  <label for="asignatura_impartir"><i class="fas fa-chalkboard-teacher"></i> Asignatura a Imprimir</label>
                  <input type="text" name="asignatura_impartir" class="form-control" value="{{ old('asignatura_impartir') }}" placeholder="Ingresa la asignatura">
                  @error('asignatura_impartir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Información de Cuenta -->
              <h5 class="text-primary"><i class="fas fa-user-lock"></i> Información de Cuenta</h5>
              <hr>
              <div class="row">
                <!-- Correo Electrónico -->
                <div class="form-group col-md-6">
                  <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ingresa el correo electrónico">
                  @error('email')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Contraseña -->
                <div class="form-group col-md-6">
                  <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                  <input type="password" name="password" class="form-control" placeholder="Contraseña">
                  @error('password')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>

            <!-- Botón de envío -->
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Registrar Maestro</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
