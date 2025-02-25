<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="chart-{{ $index }}" width="600" height="400"></canvas>
    <script>
        const ctx = document.getElementById('chart-{{ $index }}').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['0', '1', '2', '3', '4', '5'],
                datasets: [{
                    label: 'Cantidad de Respuestas',
                    data: @json($counts),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: true }
                }
            }
        });
    </script>
</body>
</html>