@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Resultados de la Encuesta: {{ $survey->title }}</h4>
                    <a href="{{ route('admin.surveys.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    @if ($responses->isEmpty())
                        <div class="alert alert-info">
                            No hay respuestas para esta encuesta.
                        </div>
                    @else
                        <div class="mb-4">
                            <h5>Ver respuestas por usuario:</h5>
                            <div class="list-group">
                                @php
                                    $userIds = $responses->flatten()->pluck('user_id')->unique();
                                @endphp
                                @foreach ($userIds as $userId)
                                    @php
                                        $user = $responses->flatten()->where('user_id', $userId)->first()->user;
                                    @endphp
                                    <a href="{{ route('admin.surveys.user-responses', ['survey' => $survey->id, 'user' => $userId]) }}" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        {{ $user->name }}
                                        <span class="badge bg-primary rounded-pill">Ver respuestas</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        @foreach ($responses as $questionId => $questionResponses)
                            <div class="mb-5">
                                <h5 class="fw-bold">Pregunta: {{ $questionResponses->first()->question_text }}</h5>
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Respuesta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questionResponses as $response)
                                            <tr>
                                                <td>{{ $response->user->name }}</td>
                                                <td>{{ $response->answer }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection