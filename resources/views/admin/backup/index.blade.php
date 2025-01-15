@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestión de Respaldo y Recuperación</h1>

    @include('_messages')

    <!-- Crear respaldo -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Crear Respaldo
        </div>
        <div class="card-body">
            <form action="{{ route('backup.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-database"></i> Crear Respaldo
                </button>
            </form>
        </div>
    </div>

    <!-- Restaurar respaldo -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            Restaurar Respaldo
        </div>
        <div class="card-body">
            <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="backup_file">Seleccionar archivo SQL:</label>
                    <input type="file" name="backup_file" id="backup_file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger mt-2">
                    <i class="fas fa-upload"></i> Restaurar
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de respaldos -->
    <div class="card">
        <div class="card-header bg-info text-white">
            Respaldos disponibles
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse ($backups as $backup)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ basename($backup) }}
                        <a href="{{ route('admin.backup.download', basename($backup)) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No hay respaldos disponibles.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
