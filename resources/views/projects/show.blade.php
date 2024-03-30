<script src="{{ asset('js/modal.js') }}"></script>

<head>
    <!-- Other meta tags and scripts -->
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(Auth::user()->role === 'CLIENT')
                {{ __('My Project Details') }}
            @else
                {{ __('Project Detail') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ $project->title }}</h1>
                    <!-- Use nl2br() to convert newlines to <br> tags -->
                    <p class="text-gray-700 mb-6">{!! nl2br(e($project->description)) !!}</p>

                    <!-- Display the email of the user who created the project -->
                    <div class="mb-6">
                        <span class="font-semibold">Created by:</span> {{ $project->user->email }}
                    </div>

                    <!-- Button for sending collaboration requests -->

                    @if (!empty($images))
                        <h2 class="text-lg font-semibold mb-2">Images:</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($images as $image)
                                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Project Image" class="w-full h-auto">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 mt-4">No images available.</p>
                    @endif

                    <!-- Button to open modal popup -->
                    <button id="openModalButton" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">View Collaboration Requests</button>

                    <!-- Modal popup -->
                    <div id="collaborationModal" class="modal hidden">
                        <div class="modal-overlay"></div>
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Collaboration Requests</h2>
                                @foreach ($collaborationRequests as $request)
                                    <div>
                                        <p>From: {{ $request->designer->email }}</p>
                                        <p>Status: {{ $request->status }}</p>
                                        @if ($request->status === 'pending')
                                            <form action="{{ route('collaborations.update', $request->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status" value="accepted">Accept</button>
                                                <button type="submit" name="status" value="denied">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

