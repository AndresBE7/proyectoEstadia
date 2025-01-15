@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Editar Maestro: <strong>{{ $teacher->name }}</strong></h2>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Formulario para editar el maestro -->
    <form action="{{ route('admin.teacher.update', $teacher->id) }}" method="POST" class="shadow p-4 bg-light rounded">
        @csrf
        @method('PATCH')

        <!-- Campo de Nombre -->
        <div class="form-group">
            <label for="name" class="font-weight-bold">Nombre:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $teacher->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de Email -->
        <div class="form-group">
            <label for="email" class="font-weight-bold">Correo Electrónico:</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $teacher->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de Contraseña (opcional) -->
        <div class="form-group">
            <label for="password" class="font-weight-bold">Contraseña:</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Dejar en blanco si no se quiere cambiar">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de CURP -->
        <div class="form-group">
            <label for="curp" class="font-weight-bold">CURP:</label>
            <input type="text" class="form-control @error('curp') is-invalid @enderror" id="curp" name="curp" value="{{ old('curp', $teacher->curp) }}" required>
            @error('curp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de RFC -->
        <div class="form-group">
            <label for="rfc" class="font-weight-bold">RFC:</label>
            <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ old('rfc', $teacher->rfc) }}" required>
            @error('rfc')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de Asignatura -->
        <div class="form-group">
            <label for="asignatura_impartir" class="font-weight-bold">Asignatura a Imprimir:</label>
            <input type="text" class="form-control @error('asignatura_impartir') is-invalid @enderror" id="asignatura_impartir" name="asignatura_impartir" value="{{ old('asignatura_impartir', $teacher->asignatura_impartir) }}" required>
            @error('asignatura_impartir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de Medio de Contacto -->
        <div class="form-group">
            <label for="medio_contacto" class="font-weight-bold">Medio de Contacto:</label>
            <input type="text" class="form-control @error('medio_contacto') is-invalid @enderror" id="medio_contacto" name="medio_contacto" value="{{ old('medio_contacto', $teacher->medio_contacto) }}" required>
            @error('medio_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de guardar cambios -->
        <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">
            <i class="fas fa-save"></i> Actualizar Maestro
        </button>
    </form>
</div>
@endsection
