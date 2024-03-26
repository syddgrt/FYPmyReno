<!-- resources/views/designers/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Designers') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($designers as $designer)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <!-- Make designer's name clickable -->
                <a href="{{ route('designers.portfolio', $designer->id) }}" class="text-lg font-semibold hover:underline">{{ $designer->name }}</a>
                <p>{{ $designer->email }}</p>
                <!-- Add more designer information here as needed -->
            </div>
        @endforeach
    </div>
</x-app-layout>
