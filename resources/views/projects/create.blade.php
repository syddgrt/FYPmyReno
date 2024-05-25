<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Title') }}</label>
                            <input id="title" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}</label>
                            <textarea id="description" class="form-textarea rounded-md shadow-sm mt-1 block w-full @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="budget" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Budget') }} (RM)</label>
                            <input id="budget" type="number" class="form-input rounded-md shadow-sm mt-1 block w-full @error('budget') is-invalid @enderror" name="budget" value="{{ old('budget') }}" required >
                            @error('budget')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Attachments') }}</label>
                            <input id="attachments" type="file" class="form-input rounded-md shadow-sm mt-1 block w-full @error('attachments.*') is-invalid @enderror" name="attachments[]" multiple>
                            @error('attachments.*')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                            {{ __('Create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
