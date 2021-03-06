<div class="mb-5 mt-3">
    <div style="margin: auto;">
        @if (array_sum($datas) > 0)
            <canvas id="categoryPieChart"></canvas>
        @else
            <span class="d-flex justify-content-center" style="color: var(--danger)">Nuk ka rezultat</span>
        @endif
    </div>
    <script>
        const categoryPie = document.getElementById('categoryPieChart').getContext('2d');
        const categoryPieChart = new Chart(categoryPie, {
            type: 'pie',
            data: {
                labels: ['E Hënë', 'E Marte', 'E Mërkur', 'E Enjëte', 'E Premte', 'E Shtune', 'E Dielë'],
                datasets: [{
                    label: 'Përdoruesit e ri',
                    data: <?= json_encode($datas) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(92, 152, 92, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(92, 152, 92, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
