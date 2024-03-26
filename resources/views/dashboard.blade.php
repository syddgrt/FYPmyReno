<x-app-layout>
    <x-slot name="header">
        @if($userRole === 'DESIGNER')
            <a href="{{ route('portfolios.modify') }}" class="text-blue-500 hover:underline">Modify Portfolio</a>
            <a href="{{ route('portfolios.show') }}" class="text-blue-500 hover:underline">Show Portfolio</a>
        @else
            <a href="{{ route('projects.create') }}" class="text-blue-500 hover:underline">Create Project</a>
            <a href="{{ route('designers.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded">View Available Designers</a>
        @endif

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
            <p>User Type: {{ $userRole }}</p>
        </h2>

        <form method="GET" action="{{ route('dashboard.search') }}">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6">
                    <a href="{{ route('projects.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Projects</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
