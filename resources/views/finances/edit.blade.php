<!-- edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Financial Data
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Form for Editing Financial Data -->
                    <form action="{{ route('finances.update', $finance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Cost Estimation -->
                            <div>
                                {{ $projects->title }}
                            </div>
                            <div>
                                
                            </div>

                            <div>
                                <label for="cost_estimation" class="block text-sm font-medium text-gray-700">Proposed/Estimation Cost (RM)</label>
                                <input type="number" name="cost_estimation" id="cost_estimation" value="{{ $finance->cost_estimation }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Only allow designers to edit these fields -->
                            @if (Auth::user()->role === 'DESIGNER')
                                <!-- Actual Cost -->
                                <div>
                                    <label for="actual_cost" class="block text-sm font-medium text-gray-700">Actual/Cost(RM)</label>
                                    <input type="number" name="actual_cost" id="actual_cost" value="{{ $finance->actual_cost }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Tax -->
                                <div>
                                    <label for="tax" class="block text-sm font-medium text-gray-700">Tax (RM)</label>
                                    <input type="number" name="tax" id="tax" value="{{ $finance->tax }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Additional Fees -->
                                <div>
                                    <label for="additional_fees" class="block text-sm font-medium text-gray-700">Additional Fees (RM)</label>
                                    <input type="number" name="additional_fees" id="additional_fees" value="{{ $finance->additional_fees }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Financial Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
