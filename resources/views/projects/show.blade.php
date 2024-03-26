<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>{{ $projects->title }}</h1>
                    <p>{{ $projects->description }}</p>

                    @if ($images)
                        <h2>Images:</h2>
                        <div class="row">
                            @foreach ($images as $image)
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Project Image" class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
