<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3>All Projects</h3>
                    @if ($projects)
                        <ul>
                            @foreach ($projects as $project)
                                <div>
                                    <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                                    <!-- Additional project details here if needed -->
                                </div>
                            @endforeach
                        </ul>
                    @else
                        <p>No projects available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
