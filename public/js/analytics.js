// analytics.js

document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('analyticsChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Proposed Cost', 'Actual Cost', 'Tax', 'Additional Fees'],
            datasets: [{
                label: 'Proposed Cost', 
                data: [costEstimation, actualCost, tax, additionalFees],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1,
                // Remove the legend
                // hidden: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            // Remove the legend
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
