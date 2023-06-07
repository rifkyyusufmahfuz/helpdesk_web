

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartContainer = document.getElementById('chartContainer');
        const closeButton = document.getElementById('closeButton');
        const chartSelector = document.getElementById('chartSelector');
        const chartButtons = document.querySelectorAll('.chart-button');
        let currentChart = null;

        closeButton.addEventListener('click', function() {
            chartContainer.style.display = 'none';
            chartSelector.style.display = 'flex';
            if (currentChart) {
                currentChart.destroy();
                currentChart = null;
            }
        });

        chartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const interval = button.getAttribute('data-interval');
                const chartData = processData(data, interval);
                createRequestsChart(chartData, 'requestsChart', 'Total Requests', 'Date');

                chartContainer.style.display = 'block';
                chartSelector.style.display = 'none';
            });
        });
    });
</script>
