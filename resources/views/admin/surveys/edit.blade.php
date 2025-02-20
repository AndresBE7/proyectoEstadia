@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Editar Encuesta</h4>
                    <a href="{{ route('admin.surveys.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Contenedor para notificaciones -->
                    <div id="notifications" class="mb-3"></div>

                    <form action="{{ route('admin.surveys.update', $survey->id) }}" method="POST" id="editSurveyForm">
                        @csrf
                        @method('PUT')

                        <!-- Título -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Título de la Encuesta</label>
                            <input type="text" id="title" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $survey->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Descripción</label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description', $survey->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Preguntas -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Preguntas</h5>
                            <div id="questions-container">
                                @php
                                    $questions = json_decode($survey->questions, true) ?? [];
                                @endphp
                                
                                @forelse($questions as $index => $question)
                                    <div class="question-item mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">P{{ $index + 1 }}</span>
                                            <input type="text" class="form-control" 
                                                   name="questions[]" 
                                                   value="{{ $question }}" 
                                                   required>
                                            <button type="button" class="btn btn-danger remove-question">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Las respuestas serán en escala del 0 al 5</small>
                                    </div>
                                @empty
                                    <div class="question-item mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">P1</span>
                                            <input type="text" class="form-control" 
                                                   name="questions[]" 
                                                   placeholder="Ingrese la pregunta" 
                                                   required>
                                            <button type="button" class="btn btn-danger remove-question">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Las respuestas serán en escala del 0 al 5</small>
                                    </div>
                                @endforelse
                            </div>

                            <button type="button" class="btn btn-outline-primary mt-2" id="addQuestion">
                                <i class="fas fa-plus"></i> Agregar Pregunta
                            </button>
                        </div>

                        <!-- Vista previa de preguntas -->
                        <div class="preview-container mt-4 mb-4 p-4 bg-light rounded">
                            <h5 class="fw-bold mb-3">Vista Previa de Preguntas</h5>
                            <div id="questions-preview" class="list-group">
                                <!-- Las preguntas se mostrarán aquí -->
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let questionCounter = document.querySelectorAll('.question-item').length;

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show`;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const notifications = document.getElementById('notifications');
        notifications.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    function updatePreview() {
        const previewContainer = document.getElementById('questions-preview');
        previewContainer.innerHTML = '';
        
        document.querySelectorAll('input[name="questions[]"]').forEach((input, index) => {
            if (input.value.trim() !== '') {
                const previewItem = document.createElement('div');
                previewItem.className = 'list-group-item';
                previewItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pregunta ${index + 1}:</strong>
                            <p class="mb-0">${input.value}</p>
                        </div>
                        <span class="badge bg-primary">Escala 0-5</span>
                    </div>
                `;
                previewContainer.appendChild(previewItem);
            }
        });
    }

    // Inicializar la vista previa
    updatePreview();

    // Agregar nueva pregunta
    document.getElementById('addQuestion').addEventListener('click', function() {
        questionCounter++;
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item mb-3';
        questionDiv.innerHTML = `
            <div class="input-group">
                <span class="input-group-text bg-light">P${questionCounter}</span>
                <input type="text" class="form-control" 
                       name="questions[]" 
                       placeholder="Ingrese la pregunta ${questionCounter}" 
                       required>
                <button type="button" class="btn btn-danger remove-question">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <small class="text-muted">Las respuestas serán en escala del 0 al 5</small>
        `;
        container.appendChild(questionDiv);
        
        // Agregar listener para actualizar vista previa
        questionDiv.querySelector('input').addEventListener('input', updatePreview);
        
        showNotification(`Pregunta ${questionCounter} añadida correctamente`);
        updatePreview();
    });

    // Eliminar pregunta
    document.getElementById('questions-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            const questionItems = document.querySelectorAll('.question-item');
            if (questionItems.length > 1) {
                e.target.closest('.question-item').remove();
                showNotification('Pregunta eliminada', 'warning');
                updatePreview();
                // Actualizar numeración
                document.querySelectorAll('.question-item').forEach((item, index) => {
                    item.querySelector('.input-group-text').textContent = `P${index + 1}`;
                });
                questionCounter--;
            } else {
                showNotification('Debe haber al menos una pregunta', 'danger');
            }
        }
    });

    // Agregar listeners para actualizar vista previa en inputs existentes
    document.querySelectorAll('input[name="questions[]"]').forEach(input => {
        input.addEventListener('input', updatePreview);
    });

    // Validar formulario
    document.getElementById('editSurveyForm').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('input[name="questions[]"]');
        if (questions.length === 0) {
            e.preventDefault();
            showNotification('Debe agregar al menos una pregunta', 'danger');
        }
    });
});
</script>

<style>
.preview-container {
    border: 1px solid #dee2e6;
}

.list-group-item {
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.question-item {
    transition: all 0.3s ease;
}

.question-item:hover {
    transform: translateX(5px);
}

.input-group-text {
    min-width: 45px;
}
</style>
@endpush

@endsection