@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user-plus"></i> Agregar Nuevo Administrador</h1>
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
                    <form action="/admin/admin/insert" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Información Personal -->
                            <h5 class="text-primary"><i class="fas fa-id-card"></i> Información Personal</h5>
                            <hr>
                            <div class="row">
                                <!-- Nombre -->
                                <div class="form-group col-md-6">
                                    <label for="name"><i class="fas fa-user"></i> Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Ingresa el nombre completo" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="form-group col-md-6">
                                    <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingresa el correo electrónico" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información de Acceso -->
                            <h5 class="text-primary mt-4"><i class="fas fa-lock"></i> Información de Acceso</h5>
                            <hr>
                            <div class="row">
                                <!-- Contraseña -->
                                <div class="form-group col-md-6">
                                    <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contraseña" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirmación de Contraseña -->
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de envío -->
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Función para alternar la visibilidad de la contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    });

    // Función para alternar la visibilidad de la confirmación de contraseña
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const confirmPasswordField = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            confirmPasswordField.type = 'password';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    });
</script>
@endsection
