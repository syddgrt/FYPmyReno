<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Project Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Project Title</label>
                            <input type="text" name="title" id="title" value="{{ $project->title }}" required class="mt-1 block w-full" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full">{{ $project->description }}</textarea>
                        </div>

                        <!-- Images (Simplified for example) -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Project Images (optional)
                            </label>
                            <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full">
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
