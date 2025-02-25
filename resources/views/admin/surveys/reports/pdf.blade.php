<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Encuestas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #007bff; }
        h3 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .filter { font-weight: bold; margin-bottom: 10px; }

        /* Estilos para los pequeños rectángulos de datos */
        .data-block {
            width: 300px;
            margin: 20px auto;
            border: 1px solid #ddd;
            overflow: hidden;
        }
        .data-row {
            display: block;
            height: 40px;
            margin-bottom: 2px;
            position: relative;
        }
        .data-label {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.7);
        }
        .legend {
            margin-top: 20px;
            text-align: center;
            padding-bottom: 20px;
        }
        .legend-item {
            display: inline-block;
            margin: 0 10px;
            font-size: 12px;
            color: #666;
        }
        .legend-color {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin-right: 5px;
            vertical-align: middle;
        }
        
        /* Tabla de resumen visual */
        .visual-summary {
            width: 300px;
            margin: 0 auto 30px;
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        .visual-summary td {
            padding: 10px;
            text-align: center;
        }
        .visual-summary .color-cell {
            width: 40px;
        }
        .visual-summary .percentage-cell {
            width: 80px;
        }
        .visual-summary .value-cell {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Reporte de Encuestas</h1>

    <div class="filter">Filtros Aplicados:</div>
    <ul>
        <li>Encuesta: {{ $surveyTitle }}</li>
    </ul>

    @if (empty($reportData['questions']))
        <p>No hay respuestas para los filtros seleccionados.</p>
    @else
        <p>Total de Respuestas: {{ $reportData['total_responses'] }}</p>
        @foreach ($reportData['questions'] as $index => $question)
            <h3>Pregunta {{ $index + 1 }}: {{ $question }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Respuesta</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counts = $reportData['counts'][$index];
                        $total = array_sum($counts);
                        $colors = ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40']; // Colores para 0-5
                    @endphp
                    @foreach ($counts as $value => $count)
                        <tr>
                            <td>{{ $value }}</td>
                            <td>{{ $count }}</td>
                            <td>{{ $total > 0 ? round(($count / $total) * 100, 2) : 0 }}%</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>Promedio</strong></td>
                        <td colspan="2"><strong>{{ round($reportData['averages'][$index], 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- Representación visual simplificada de los datos -->
            <h4 style="text-align: center; margin-top: 30px;">Distribución de respuestas</h4>
            
            <!-- Tabla de resumen visual -->
            <table class="visual-summary">
                <tbody>
                    @foreach ($counts as $value => $count)
                        @if ($count > 0)
                            @php
                                $percentage = $total > 0 ? round(($count / $total) * 100, 2) : 0;
                            @endphp
                            <tr>
                                <td class="color-cell" style="background-color: {{ $colors[$value] }};"></td>
                                <td class="value-cell">Valor: {{ $value }}</td>
                                <td class="count-cell">{{ $count }} respuestas</td>
                                <td class="percentage-cell">{{ $percentage }}%</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            
            <!-- Barras de visualización horizontal -->
            <div class="data-block">
                @foreach ($counts as $value => $count)
                    @if ($count > 0)
                        @php
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        @endphp
                        <div class="data-row" style="width: {{ $percentage }}%; background-color: {{ $colors[$value] }};">
                            <span class="data-label">{{ $value }}: {{ round($percentage, 1) }}%</span>
                        </div>
                    @endif
                @endforeach
            </div>
            
            <p style="text-align: center; margin-top: 10px;">
                <strong>Total de respuestas:</strong> {{ $total }} | 
                <strong>Promedio:</strong> {{ round($reportData['averages'][$index], 2) }}
            </p>

            <div style="page-break-after: always;"></div>
        @endforeach
    @endif
</body>
</html>