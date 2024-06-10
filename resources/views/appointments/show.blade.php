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
                    
                    <!-- Appointment details in a rounded blue rectangle -->
                    <div class="bg-blue-100 text-blue-900 p-4 rounded-lg mb-4">
                        <p class="mb-2"><strong>Date:</strong> {{ $appointment->date }}</p>
                        <p class="mb-2"><strong>Time:</strong> {{ $appointment->time }}</p>
                        <p><strong>Place:</strong> {{ $appointment->place }}</p>
                    </div>

                    <!-- Edit and Delete buttons -->
                    <div class="mt-4 flex justify-between">
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
