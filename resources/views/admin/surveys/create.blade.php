@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm"> <!-- Agregamos sombra para un efecto más moderno -->
                <div class="card-header bg-primary text-white position-relative">
                    <span>Crear Nueva Encuesta</span>
                    <a href="{{ route('admin.surveys.index') }}" class="btn btn-outline-light btn-sm position-absolute top-0 end-10 translate-middle-y me-3">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>                

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.surveys.store') }}" id="surveyForm">
                        @csrf
                    
                        <!-- Título y descripción -->
                        <div class="form-group mb-4">
                            <label for="title" class="form-label fw-bold">Título de la Encuesta</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <!-- Preguntas -->
                        <div id="questions-container" class="mb-4">
                            <h5 class="mb-3 fw-bold">Preguntas</h5>
                            <div class="question-item mb-3 p-3 border rounded bg-light">
                                <div class="input-group">
                                    <input type="text" class="form-control" 
                                           name="questions[]" placeholder="Ingrese la pregunta" required>
                                    <button type="button" class="btn btn-danger remove-question">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Las respuestas serán en escala del 0 al 5</small>
                            </div>
                        </div>
                    
                        <!-- Botón para agregar preguntas -->
                        <button type="button" class="btn btn-outline-primary mb-4" id="addQuestion">
                            <i class="fas fa-plus"></i> Agregar Pregunta
                        </button>
                    
                        <!-- Fecha de expiración -->
                        <div class="form-group mb-4">
                            <label for="expiration_date" class="form-label fw-bold">Fecha de Expiración</label>
                            <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" 
                                   id="expiration_date" name="expiration_date" 
                                   value="{{ old('expiration_date') }}" required>
                            @error('expiration_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <!-- Botón de envío -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Crear Encuesta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Agregar nueva pregunta
    document.getElementById('addQuestion').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item mb-3 p-3 border rounded bg-light';
        questionDiv.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control" name="questions[]" 
                       placeholder="Ingrese la pregunta" required>
                <button type="button" class="btn btn-danger remove-question">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <small class="text-muted">Las respuestas serán en escala del 0 al 5</small>
        `;
        container.appendChild(questionDiv);
    });

    // Eliminar pregunta
    document.getElementById('questions-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-question')) {
            const questionItems = document.querySelectorAll('.question-item');
            if (questionItems.length > 1) {
                e.target.closest('.question-item').remove();
            } else {
                alert('Debe haber al menos una pregunta');
            }
        }
    });

    // Validación al enviar el formulario
    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('input[name="questions[]"]');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Debe agregar al menos una pregunta');
        }
    });
});
</script>
@endpush