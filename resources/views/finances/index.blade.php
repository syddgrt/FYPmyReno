<!-- resources/views/finances/index.blade.php -->
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
                    <!-- Filter Form for Designers -->
                    @if(auth()->user()->role == 'DESIGNER')
                        <form method="GET" class="mb-4">
                            <div class="flex items-center mb-4">
                                <label for="client_id" class="mr-2">Filter by Client:</label>
                                <select name="client_id" id="client_id" class="form-select">
                                    <option value="">All Clients</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                         <!-- Button to Add Financial Data -->
                         <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative flex justify-center" role="alert">
    <a href="{{ route('finances.create') }}" class="btn btn-success">Add Financial Data</a>
</div>

                    @endif

                    <!-- Financial Data Table -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-2">Financial Data</h2>
                        <div class="overflow-x-auto">
                            <table class="table-auto border-collapse border border-gray-800 w-full">
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
                                <tbody id="financialDataTable">
                                    @foreach ($financialDatas as $data)
                                        @php
                                            $totalCost = $data->actual_cost + $data->tax + $data->additional_fees;
                                        @endphp
                                        <tr data-client-id="{{ $data->project->user_id }}">
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
                                                @if(auth()->user()->role == 'DESIGNER')
                                                    <a href="{{ route('finances.edit', $data->id) }}" class=" bg-blue-500 text-white px-4 py-1.5 rounded  hover:bg-blue-600">Edit</a>
                                                    <form action="{{ route('finances.destroy', $data->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="fa fa-trash-o bg-red-500 text-white px-1.5 py-1.5 rounded hover:bg-red-600"></button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('finances.show', $data->project_id) }}" class="bg-green-500 text-white px-4 py-1.5 rounded  hover:bg-green-600">Finance</a>
                                            </td>                                               
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Total Summary -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-2">Total Summary</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-green-500 text-white p-4 rounded">
                                <h3 class="text-lg font-semibold mb-2">Total Actual Cost</h3>
                                <p class="text-3xl font-bold">RM{{ number_format($totalActualCost, 2) }}</p>
                            </div>
                            <div class="bg-yellow-500 text-white p-4 rounded">
                                <h3 class="text-lg font-semibold mb-2">Total Tax</h3>
                                <p class="text-3xl font-bold">RM{{ number_format($totalTax, 2) }}</p>
                            </div>
                            <div class="bg-red-500 text-white p-4 rounded">
                                <h3 class="text-lg font-semibold mb-2">Total Additional Fees</h3>
                                <p class="text-3xl font-bold">RM{{ number_format($totalAdditionalFees, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- JavaScript for Client Filtering -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const clientDropdown = document.getElementById('client_id');
                            const financialTable = document.getElementById('financialDataTable');

                            clientDropdown.addEventListener('change', function () {
                                const selectedClientId = this.value;
                                const rows = financialTable.getElementsByTagName('tr');

                                for (let i = 0; i < rows.length; i++) {
                                    const row = rows[i];
                                    const clientId = row.getAttribute('data-client-id');

                                    if (selectedClientId === "" || clientId === selectedClientId) {
                                        row.style.display = "";
                                    } else {
                                        row.style.display = "none";
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
