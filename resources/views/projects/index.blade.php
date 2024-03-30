<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @if(Auth::user()->role === 'CLIENT')
                    {{ __('My Projects') }}
                @else
                    {{ __('Available Projects') }}
                @endif
            </h2>
            @if(Auth::user()->role === 'CLIENT')
                <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create New Project
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($projects->isEmpty())
                <p class="text-gray-600">No projects available.</p>
                @if (Auth::user()->role === 'CLIENT')
                    <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                        Create New Project
                    </a>
                @endif
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($projects as $project)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="font-semibold text-lg mb-2">{{ $project->title }}</h3>
                                <p class="text-gray-600 mb-2">Status: {{ $project->status }}</p>
                                @if ($project->attachments->isNotEmpty())
                                    <div class="mt-2">
                                        <img src="{{ asset($project->attachments->first()->file_path) }}" alt="Project Image" class="w-full h-auto">
                                    </div>
                                @else
                                    <p class="text-gray-400 mt-2">No image attachment available.</p>
                                @endif
                                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700 mt-2 block">View Project Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
