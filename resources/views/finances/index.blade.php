<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Financial Information and Data Analytics
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Financial Data Table -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-2">Financial Data</h2>
                        <div class="overflow-x-auto">
                            <table class="table-auto border-collapse border border-gray-800 w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-600 px-4 py-2">Date</th>
                                        <th class="border border-gray-600 px-4 py-2">Revenue</th>
                                        <th class="border border-gray-600 px-4 py-2">Expenses</th>
                                        <th class="border border-gray-600 px-4 py-2">Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample data, replace with actual data -->
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">2024-03-01</td>
                                        <td class="border border-gray-600 px-4 py-2">$5000</td>
                                        <td class="border border-gray-600 px-4 py-2">$3000</td>
                                        <td class="border border-gray-600 px-4 py-2">$2000</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">2024-03-02</td>
                                        <td class="border border-gray-600 px-4 py-2">$5500</td>
                                        <td class="border border-gray-600 px-4 py-2">$3200</td>
                                        <td class="border border-gray-600 px-4 py-2">$2300</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Data Analytics Chart -->
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Data Analytics</h2>
                        <div class="bg-white border border-gray-800 rounded-lg p-4">
                            <!-- Simple chart, replace with actual data visualization library -->
                            <canvas id="analyticsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample data for the chart
        const data = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Revenue',
                data: [5000, 5500, 6000, 6500, 7000, 7500],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        var myChart = new Chart(
            document.getElementById('analyticsChart'),
            config
        );
    </script>
@endpush
