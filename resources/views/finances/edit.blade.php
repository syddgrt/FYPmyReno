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
                    <form action="{{ route('finances.update', $financialData->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Cost Estimation -->
                            <div>
                                <label for="cost_estimation" class="block text-sm font-medium text-gray-700">Cost Estimation</label>
                                <input type="number" name="cost_estimation" id="cost_estimation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $financialData->cost_estimation }}" required>
                            </div>

                            <!-- Actual Cost -->
                            <div>
                                <label for="actual_cost" class="block text-sm font-medium text-gray-700">Actual Cost</label>
                                <input type="number" name="actual_cost" id="actual_cost" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $financialData->actual_cost }}" required>
                            </div>

                            <!-- Tax -->
                            <div>
                                <label for="tax" class="block text-sm font-medium text-gray-700">Tax</label>
                                <input type="number" name="tax" id="tax" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $financialData->tax }}" required>
                            </div>

                            <!-- Additional Fees -->
                            <div>
                                <label for="additional_fees" class="block text-sm font-medium text-gray-700">Additional Fees</label>
                                <input type="number" name="additional_fees" id="additional_fees" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $financialData->additional_fees }}" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
