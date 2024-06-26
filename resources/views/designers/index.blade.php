<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Designers') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('designers.index') }}" method="GET">
                <div class="mb-4">
                    <input type="text" name="search" class="px-4 py-2 border border-gray-300 rounded-md" placeholder="Search Designers..." value="{{ request('search') }}">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>
            </form>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
                @foreach ($designers as $designer)
                    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg sm:rounded-lg p-4 hover:shadow-2xl transition-shadow duration-300">
                        <a href="{{ route('designers.portfolio', $designer->id) }}" class="text-lg font-semibold hover:underline text-gray-800 dark:text-gray-100">
                            {{ $designer->name }}
                        </a>
                        <p class="text-gray-600 dark:text-gray-400">{{ $designer->email }}</p>
                        <!-- Add more designer information here as needed -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
