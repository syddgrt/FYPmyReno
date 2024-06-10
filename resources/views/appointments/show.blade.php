<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Appointment Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Appointment Information</h1>
                    <p>Date: {{ $appointment->date }}</p>
                    <p>Time: {{ $appointment->time }}</p>
                    <p>Place: {{ $appointment->place }}</p>
                    <!-- Add more appointment details here as needed -->

                    <!-- Edit and Delete buttons -->
                    <div class="mt-4 flex justify-between">
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
                        
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
