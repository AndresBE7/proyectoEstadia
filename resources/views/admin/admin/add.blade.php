@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user-plus"></i> Agregar Nuevo Maestro</h1>
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

                            <div class="row">
                                <!-- CURP -->
                                <div class="form-group col-md-6">
                                    <label for="curp"><i class="fas fa-address-card"></i> CURP</label>
                                    <input type="text" class="form-control @error('curp') is-invalid @enderror" id="curp" name="curp" value="{{ old('curp') }}" placeholder="Ingresa el CURP" required>
                                    @error('curp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- RFC -->
                                <div class="form-group col-md-6">
                                    <label for="rfc"><i class="fas fa-address-card"></i> RFC</label>
                                    <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ old('rfc') }}" placeholder="Ingresa el RFC" required>
                                    @error('rfc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información Académica -->
                            <h5 class="text-primary mt-4"><i class="fas fa-graduation-cap"></i> Información Académica</h5>
                            <hr>
                            <div class="row">
                                <!-- Asignatura a Impartir -->
                                <div class="form-group col-md-6">
                                    <label for="asignatura_impartir"><i class="fas fa-book"></i> Asignatura a Impartir</label>
                                    <input type="text" class="form-control @error('asignatura_impartir') is-invalid @enderror" id="asignatura_impartir" name="asignatura_impartir" value="{{ old('asignatura_impartir') }}" placeholder="Ingresa la asignatura a impartir" required>
                                    @error('asignatura_impartir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <h5 class="text-primary mt-4"><i class="fas fa-phone-alt"></i> Información de Contacto</h5>
                            <hr>
                            <div class="row">
                                <!-- Contraseña -->
                                <div class="form-group col-md-6">
                                    <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contraseña" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirmación de Contraseña -->
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
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
@endsection
