@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Reportes de Encuestas</h4>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form action="{{ route('admin.surveys.reports.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="period" class="form-label">Periodo</label>
                                <select name="period" id="period" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($periods as $p)
                                        <option value="{{ $p }}" {{ $period == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="group_id" class="form-label">Grupo</label>
                                <select name="group_id" id="group_id" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ $group_id == $group->id ? 'selected' : '' }}>{{ $group->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="survey_id" class="form-label">Encuesta</label>
                                <select name="survey_id" id="survey_id" class="form-control">
                                    <option value="">Todas</option>
                                    @foreach ($surveys as $survey)
                                        <option value="{{ $survey->id }}" {{ $survey_id == $survey->id ? 'selected' : '' }}>{{ $survey->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                                <a href="{{ route('admin.surveys.reports.export', request()->query()) }}" class="btn btn-success">Exportar PDF</a>
                            </div>
                        </div>
                    </form>

                    <!-- Resultados -->
                    @if (empty($reportData['questions']))
                        <div class="alert alert-info">No hay respuestas para los filtros seleccionados.</div>
                    @else
                        <div class="mb-4">
                            <h5>Total de Respuestas: {{ $reportData['total_responses'] }}</h5>
                        </div>
                        @foreach ($reportData['questions'] as $index => $question)
    <div class="mb-5">
        <h5 class="fw-bold">Pregunta {{ $index + 1 }}: {{ $question }}</h5>
        <table class="table table-bordered table-hover mb-4">
            <thead class="table-light">
                <tr>
                    <th>Respuesta</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportData['counts'][$index] as $value => $count)
                    <tr>
                        <td>{{ $value }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $count > 0 ? round(($count / array_sum($reportData['counts'][$index])) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
                <tr class="table-primary">
                    <td><strong>Promedio</strong></td>
                    <td colspan="2"><strong>{{ round($reportData['averages'][$index], 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
        <canvas id="chart-{{ $index }}" height="100"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx{{ $index }} = document.getElementById('chart-{{ $index }}').getContext('2d');
            new Chart(ctx{{ $index }}, {
                type: 'bar',
                data: {
                    labels: ['0', '1', '2', '3', '4', '5'],
                    datasets: [{
                        label: 'Cantidad de Respuestas',
                        data: @json($reportData['counts'][$index]),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection