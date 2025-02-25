@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Encuestas Disponibles</h4>
                </div>
                <div class="card-body">
                    @if ($surveys->isEmpty())
                        <p class="text-center">No hay encuestas disponibles en este momento.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($surveys as $survey)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $survey->title }}</span>
                                    <a href="{{ route('surveys.respond', $survey->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Contestar
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
