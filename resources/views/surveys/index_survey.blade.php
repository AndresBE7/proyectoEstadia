@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Encuestas Disponibles</h2>
    
    @if($surveys->isEmpty())
        <p class="text-center">No hay encuestas disponibles en este momento.</p>
    @else
        <div class="row">
            @foreach($surveys as $survey)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ $survey->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Descripción:</strong> {{ Str::limit($survey->description, 100) }}</p>
                            <p><strong>Fecha Límite:</strong> {{ $survey->due_date->format('d/m/Y') }}</p>
                            <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-success">Ver Encuesta</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
