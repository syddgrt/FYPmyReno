<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($results->isEmpty())
                <p class="text-gray-500 dark:text-gray-300">No results found.</p>
            @else
                @foreach($results as $result)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $result->title }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $result->description }}</p>
                        
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
