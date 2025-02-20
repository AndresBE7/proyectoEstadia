@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Respuestas de {{ $user->name }} para "{{ $survey->title }}"</h4>
                    <a href="{{ route('admin.surveys.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    @if(empty($answers))
                        <div class="alert alert-info">
                            No hay respuestas para esta encuesta.
                        </div>
                    @else
                        <hr>

                        <div class="mb-4">
                            <h5 class="fw-bold">Respuestas detalladas:</h5>

                            @foreach ($questions as $index => $question)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="fw-bold">Preguntas</h6>
                                        <p>{{ $question }}</p>
                                        <hr>
                                        <h6 class="fw-bold">Respuestas de encuesta:</h6>
                                        <p class="text-primary">{{ $answersString }}</p>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
