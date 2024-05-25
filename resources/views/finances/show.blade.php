<!-- show.blade.php -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/analytics.js') }}"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Financial Information and Data Analytics for {{ $project->name }}
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->cost_estimation, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->actual_cost, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->tax, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($finance->additional_fees, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Data Analytics Chart Placeholder -->
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Data Analytics</h2>
                        <div class="bg-white border border-gray-800 rounded-lg p-4">
                            <canvas id="analyticsChart" width="400" height="200"></canvas>
                        </div>
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
    </script>
   

</x-app-layout>

