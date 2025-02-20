@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Gestión de Encuestas</h5>
                    <a href="{{ route('admin.surveys.create') }}" class="btn btn-outline-light">
                        <i class="fas fa-plus"></i> Nueva Encuesta
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Título</th>
                                    <th>Estado</th>
                                    <th>Fecha de Expiración</th>
                                    <th>Respuestas</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($surveys as $survey)
                                <tr>
                                    <td>{{ $survey->title }}</td>
                                    <td>
                                        <span class="badge {{ $survey->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $survey->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                    <td>{{ $survey->expiration_date->format('d/m/Y') }}</td>
                                    <td>{{ $survey->responses->count() }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if(!$survey->is_active && $survey->responses->count() == 0)
                                                <a href="{{ route('admin.surveys.edit', $survey) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                   <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @endif
                                            
                                            <form action="{{ route('admin.surveys.activate', $survey->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check-circle"></i> Activar
                                                </button>
                                            </form>
                                            
                                            
                                            <a href="{{ route('surveys.respond', $survey) }}" 
                                               class="btn btn-sm btn-outline-warning">
                                               <i class="fas fa-eye"></i> Vista Previa
                                            </a>
                                            
                                            <a href="{{ route('admin.surveys.results', $survey) }}" 
                                               class="btn btn-sm btn-outline-info">
                                               <i class="fas fa-chart-bar"></i> Resultados
                                            </a>
                                            
                                            <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta encuesta?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
