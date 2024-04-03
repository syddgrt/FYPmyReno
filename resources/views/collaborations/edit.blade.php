<!-- edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Collaboration Request
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('collaborations.update', $collaboration->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Add your form fields here for editing collaboration -->
                        <div>
                            <!-- Example: Input field for updating status -->
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <input type="text" name="status" id="status" value="{{ $collaboration->status }}" class="mt-1 p-2 border rounded-md w-full">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update Collaboration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
