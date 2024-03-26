<!-- resources/views/portfolios/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Portfolios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($portfolios as $portfolio)
                    <div class="p-4 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                        <h3 class="text-lg font-semibold">{{ $portfolio->title }}</h3>
                        <p>{{ $portfolio->description }}</p>
                        <!-- Display other portfolio details here -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
