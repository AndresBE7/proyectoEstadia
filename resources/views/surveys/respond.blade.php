@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Responder Encuesta: {{ $survey->title }}</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('surveys.submit', $survey->id) }}" method="POST">
                        @csrf

                        <!-- Descripción de la encuesta -->
                        @if ($survey->description)
                            <div class="mb-4">
                                <p class="lead">{{ $survey->description }}</p>
                            </div>
                        @endif

                        <!-- Preguntas -->
                        @foreach (explode(',', $survey->questions) as $index => $question)
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pregunta {{ $index + 1 }}: {{ $question }}</label>
                                <div>
                                    @for ($i = 0; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[{{ $index }}]" 
                                                   id="answer{{ $index }}_{{ $i }}" 
                                                   value="{{ $i }}" required>
                                            <label class="form-check-label" for="answer{{ $index }}_{{ $i }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endforeach

                        <!-- Botón de enviar -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Enviar Respuestas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection