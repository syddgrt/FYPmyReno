


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

                                    @if(auth()->user()->role == 'DESIGNER')
                                        <a href="{{ route('finances.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Add New Financial Data
                                        </a>

                                    @endif
                                    </div>
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="px-1.5 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Project ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Project Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Client Budget</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Estimation Cost</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Tax</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Additional Fees</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Total Cost</th>
                                            <th class="px-20 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    @if(auth()->user()->role == 'DESIGNER')
                                    <tbody>
                                        @foreach ($financialDatas as $data)
                                            @php
                                                $totalCost = $data->actual_cost + $data->tax + $data->additional_fees;
                                            @endphp
                                            <tr>
                                                <td class="border border-gray-600 px-4 py-2">{{ $data->project_id }}</td>
                                                <td class="border border-gray-600 px-4 py-2">{{ $data->project->title }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->cost_estimation, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->actual_cost, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->tax, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->additional_fees, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">
                                                    <span class="rounded-full bg-yellow-300 px-3 py-1 inline-block">
                                                        RM{{ number_format($totalCost, 2) }}
                                                    </span>
                                                </td>
                                                <td class="border border-gray-600 px-4 py-2">
                                                    <a href="{{ route('finances.edit', $data->id) }}" class=" bg-blue-500 text-white px-4 py-1.5 rounded  hover:bg-blue-600">Edit</a>
                                                    <a href="{{ route('finances.show', $data->project_id) }}" class="bg-green-500 text-white px-4 py-1.5 rounded  hover:bg-green-600">Finance</a>
                                                    <form action="{{ route('finances.destroy', $data->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="fa fa-trash-o bg-red-500 text-white px-1.5 py-1.5 rounded hover:bg-red-600"></button>
                                                    </form>
                                                </td>                                               
                                            </tr>
                                    
                                            
                                        @endforeach

                                    
                                    </tbody>                                  
                                    @elseif(auth()->user()->role == 'CLIENT')
                                    <tbody>
                                        @foreach ($financialDatas as $data)
                                            @php
                                                $totalCost = $data->actual_cost + $data->tax + $data->additional_fees;
                                            @endphp
                                            <tr>
                                                <td class="border border-gray-600 px-4 py-2">{{ $data->project_id }}</td>
                                                <td class="border border-gray-600 px-4 py-2">{{ $data->project->title }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->cost_estimation, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->actual_cost, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->tax, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">RM{{ number_format($data->additional_fees, 2) }}</td>
                                                <td class="border border-gray-600 px-4 py-2">
                                                    <span class="rounded-full bg-yellow-300 px-3 py-1 inline-block">
                                                        RM{{ number_format($totalCost, 2) }}
                                                    </span>
                                                </td>
                                                <td class="border border-gray-600 px-4 py-2">
                                                    
                                                    <a href="{{ route('finances.show', $data->project_id) }}" class="bg-green-500 text-white px-4 py-1.5 rounded  hover:bg-green-600">Finance</a>
                                                    
                                                </td>                                               
                                            </tr>
                                    
                                            
                                        @endforeach

                                    
                                    </tbody>
                                    @endif
                                </div>
                            </table>
                        </div>
                    </div>

                    <script>
                        // Pass financial data sums to JavaScript file
                        const totalCostEstimation = {{ $totalCostEstimation }};
                        const totalActualCost = {{ $totalActualCost }};
                        const totalTax = {{ $totalTax }};
                        const totalAdditionalFees = {{ $totalAdditionalFees }};
                    </script>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @foreach ($financialDatas as $data)
        @if ($data->project->client_id === auth()->id() || $data->project->collaborations()->where('designer_id', auth()->id())->exists())
            <script>
                // Initialize Chart.js for your analytics chart as before
                const ctx_{{ $loop->index }} = document.getElementById('analyticsChart_{{ $loop->index }}').getContext('2d');
                const myChart_{{ $loop->index }} = new Chart(ctx_{{ $loop->index }}, {
                    type: 'bar',
                    data: {
                        labels: ['Proposed Cost', 'Actual Cost', 'Tax', 'Additional Fees'],
                        datasets: [{
                            label: 'Financial Data',
                            data: [{{ $data->cost_estimation }}, {{ $data->actual_cost }}, {{ $data->tax }}, {{ $data->additional_fees }}],
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
        @endif
    @endforeach
@endpush
</x-app-layout>
