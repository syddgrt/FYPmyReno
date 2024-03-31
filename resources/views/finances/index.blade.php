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
                            <div class="mb-4 flex justify-end">
    <a href="{{ route('finances.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add New Financial Data
    </a>
</div>

                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-600 px-4 py-2">Project ID</th>
                                        <th class="border border-gray-600 px-4 py-2">Cost Estimation</th>
                                        <th class="border border-gray-600 px-4 py-2">Actual Cost</th>
                                        <th class="border border-gray-600 px-4 py-2">Tax</th>
                                        <th class="border border-gray-600 px-4 py-2">Additional Fees</th>
                                        <th class="border border-gray-600 px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($financialDatas as $data)
                                    <tr>
                                        <td class="border border-gray-600 px-4 py-2">{{ $data->project_id }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->cost_estimation, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->actual_cost, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->tax, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->additional_fees, 2) }}</td>
                                        <td class="border border-gray-600 px-4 py-2">
                                            <a href="{{ route('finances.edit', $data->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
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
</x-app-layout>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize Chart.js for your analytics chart as before
    </script>
@endpush
