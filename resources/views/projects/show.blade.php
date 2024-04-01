<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->role === 'CLIENT' ? 'My Project Details' : 'Project Detail' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Project Title and Description -->
                    <h1 class="text-2xl font-semibold mb-4">{{ $project->title }}</h1>
                    <p class="text-gray-700 mb-6">{!! nl2br(e($project->description)) !!}</p>
                    <div class="mb-6">
                        <span class="font-semibold">Created by:</span> {{ $project->user->email }}
                    </div>

                    <!-- Images if available -->
                    @if ($images)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($images as $image)
                                <div class="rounded-lg overflow-hidden shadow-md">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Project Image" class="w-full h-auto">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Designer: Send Collaboration Request -->
                    @if(Auth::user()->role === 'DESIGNER' && !$hasSentRequest)
                        <form action="{{ route('collaborations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Send Collaboration Request
                            </button>
                        </form>
                    @elseif(Auth::user()->role === 'DESIGNER' && $hasSentRequest)
                        <div class="mt-4 p-4 border border-gray-200 rounded">
                            <p>Your request status: <strong>{{ ucfirst($myRequest->status) }}</strong></p>
                        </div>
                    @endif

                    <!-- Client: View & Respond to Collaboration Requests -->
                    @if(Auth::user()->id === $project->user_id)
                        <button id="toggleCollabRequests" class="mt-4 bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded cursor-pointer">
                            View Collaboration Requests
                        </button>
                        <div id="collabRequestsSection" class="hidden">
                            <h2 class="mt-4 text-lg font-semibold">Collaboration Requests</h2>
                            @forelse ($collaborationRequests as $request)
                                <div class="mt-2 p-2 border border-gray-200 rounded">
                                    <p>From: {{ $request->designer->email }}</p>
                                    <p>Status: {{ $request->status }}</p>
                                    @if ($request->status === 'pending')
                                        <form action="{{ route('collaborations.update', $request->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="accepted" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Accept</button>
                                            <button type="submit" name="status" value="denied" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Reject</button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <p>No collaboration requests.</p>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleCollabRequests').addEventListener('click', function() {
            var section = document.getElementById('collabRequestsSection');
            section.classList.toggle('hidden');
        });
    </script>
</x-app-layout>
