<!-- resources/views/finances/show.blade.php -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/analytics.js') }}"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Financial Information and Data Analytics for {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Financial Data -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-2">Financial Data</h2>
                        <div class="overflow-x-auto">
                            <table class="table-auto border-collapse border border-gray-800 w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-600 px-4 py-2">Proposed Cost</th>
                                        <th class="border border-gray-600 px-4 py-2">Estimation Cost</th>
                                        <th class="border border-gray-600 px-4 py-2">Tax</th>
                                        <th class="border border-gray-600 px-4 py-2">Additional Fees</th>
                                        <th class="border border-gray-600 px-4 py-2">Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->cost_estimation, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->actual_cost, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->tax, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->additional_fees, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">
                                            <span class="rounded-full bg-yellow-300 px-3 py-1 inline-block">
                                                RM{{ number_format($totalCost, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Charts Container -->
                    <div class="flex justify-between space-x-4">
                        <div class="w-1/2">
                            <h2 class="text-xl font-semibold mb-2">Bar Chart</h2>
                            <div class="bg-white border border-gray-800 rounded-lg p-4">
                                <canvas id="analyticsChart" width="200" height="200"></canvas>
                            </div>
                        </div>
                        <!-- Pie Chart Placeholder -->
                        <div class="w-1/2">
                            <h2 class="text-xl font-semibold mb-2">Pie Chart</h2>
                            <div class="bg-white border border-gray-800 rounded-lg p-4">
                                <canvas id="pieChart" width="200" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Render charts off-screen -->
                    <canvas id="analyticsChartCanvas" style="display: none;"></canvas>
                    <canvas id="pieChartCanvas" style="display: none;"></canvas>

                    <!-- PDF Generation Button -->
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('generate.pdf', $project->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Download PDF
                        </a>
                        @if(auth()->user()->role == 'CLIENT')
                        <a href="{{ route('payment', $project->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Make a Payment
                        </a>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pass financial data to JavaScript file
        const costEstimation = {{ $finance->cost_estimation }};
        const actualCost = {{ $finance->actual_cost }};
        const tax = {{ $finance->tax }};
        const additionalFees = {{ $finance->additional_fees }};
        const totalCost = {{ $totalCost }};

        // Analytics Chart
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Proposed/Estimation Cost', 'Actual Cost', 'Tax', 'Additional Fees', 'Total Cost'],
                datasets: [{
                    label: 'Amount in RM',
                    data: [costEstimation, actualCost, tax, additionalFees, totalCost],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
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

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Proposed/Estimation Cost', 'Actual Cost', 'Tax', 'Additional Fees', 'Total Cost'],
                datasets: [{
                    label: 'Amount in RM',
                    data: [costEstimation, actualCost, tax, additionalFees, totalCost],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Pass chart images to PDF generation endpoint
        document.addEventListener('DOMContentLoaded', function() {
            var analyticsChartImage = canvasToDataURL('analyticsChartCanvas');
            var pieChartImage = canvasToDataURL('pieChartCanvas');
            var pdfButton = document.querySelector('.pdf-button');
            pdfButton.href = '{{ route('generate.pdf', $project->id) }}?analyticsChart=' + encodeURIComponent(analyticsChartImage) + '&pieChart=' + encodeURIComponent(pieChartImage);
        });
    </script>
</x-app-layout>
