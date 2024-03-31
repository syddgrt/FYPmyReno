<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add New Financial Data
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Form for Adding Financial Data -->
                    <form action="{{ route('finances.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Project ID (assuming a dropdown selection) -->
                            <div>
                                <label for="project_id" class="block text-sm font-medium text-black-700">Project ID</label>
                                <select id="project_id" name="project_id" class="mt-1 block w-full ...">
                                    @forelse ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @empty
                                        <option>No projects available</option>
                                    @endforelse
                                </select>



                            </div>

                            <!-- Cost Estimation -->
                            <div>
                                <label for="cost_estimation" class="block text-sm font-medium text-gray-700">Cost Estimation</label>
                                <input type="number" name="cost_estimation" id="cost_estimation" value="{{ old('cost_estimation') }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Actual Cost -->
                            <div>
                                <label for="actual_cost" class="block text-sm font-medium text-gray-700">Actual Cost</label>
                                <input type="number" name="actual_cost" id="actual_cost" value="{{ old('actual_cost') }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Tax -->
                            <div>
                                <label for="tax" class="block text-sm font-medium text-gray-700">Tax</label>
                                <input type="number" name="tax" id="tax" value="{{ old('tax') }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Additional Fees -->
                            <div>
                                <label for="additional_fees" class="block text-sm font-medium text-gray-700">Additional Fees</label>
                                <input type="number" name="additional_fees" id="additional_fees" value="{{ old('additional_fees') }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Financial Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Your existing script for the analytics chart
    </script>
@endpush
