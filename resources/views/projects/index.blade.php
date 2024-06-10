<title>myReno</title>
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
            <form action="{{ route('projects.index') }}" method="GET">
                <div class="mb-4 flex">
                    <input type="text" name="search" class="px-4 py-2 border border-gray-300 rounded-md" placeholder="Search Projects..." value="{{ request('search') }}">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 ml-2">Search</button>
                </div>
            </form>
            @if ($projects->isEmpty())
                <p class="text-gray-600">No projects available.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($projects as $project)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="font-semibold text-lg mb-2">{{ $project->title }}</h3>
                                <p class="text-gray-600 mb-2">
                                    Status:
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if ($project->status === 'open') bg-red-300 text-red-800 @elseif ($project->status === 'In View') bg-yellow-300 text-yellow-800 @elseif ($project->status === 'Finished') bg-green-300 text-green-800 @endif">
                                        {{ $project->status }}
                                    </span>
                                </p>
                                <p class="text-gray-600 mb-2">Budget: RM{{ $project->budget }}</p> <!-- Displaying budget -->
                                @if ($project->attachments->isNotEmpty())
                                    <div class="mt-2">
                                        @foreach($project->attachments as $attachment)
                                            <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Image" class="w-full h-auto">
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-400 mt-2">No image attachment available.</p>
                                @endif
                                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700 mt-2 block">View Project Details</a>
                                <br>
                                @if(Auth::user()->role === 'CLIENT' && Auth::id() === $project->user_id)
                                    <a href="{{ route('projects.edit', $project) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-1.5 rounded hover:bg-red-600 mt-2">Delete</button> <!-- Delete button -->
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
