<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Schedule Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('schedules.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="collaboration_id" class="block text-gray-700 text-sm font-bold mb-2">Project Title: {{ request()->input('title') }}</label>
                            <input type="hidden" name="collaboration_id" value="{{ request()->input('collaboration_id') }}">
                        </div>

                        <div class="mb-4">
                            <label for="collaboration_id" class="block text-gray-700 text-sm font-bold mb-2">Collaboration ID: {{ request()->input('collaboration_id') }}</label>
                            <input type="hidden" name="collaboration_id" value="{{ request()->input('collaboration_id') }}">
                        </div>

                        <div class="mb-4">
                            <label for="project_id" class="block text-gray-700 text-sm font-bold mb-2">Project ID: {{ request()->input('project_id') }}</label>
                            <input type="hidden" name="project_id" value="{{ request()->input('project_id') }}">
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                            <input type="date" name="date" id="date" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('date') }}" required />
                        </div>

                        <div class="mb-4">
                            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Time:</label>
                            <input type="time" name="time" id="time" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('time') }}" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
