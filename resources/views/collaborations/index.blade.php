<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->role === 'CLIENT' ? __('My Collaboration Requests') : __('Active Collaborations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ Auth::user()->role === 'CLIENT' ? 'Collaboration Requests for My Projects' : 'My Active Collaborations' }}</h1>

                    @forelse ($collaborationRequests as $request)
                        <div class="mb-4 p-4 border border-gray-200 rounded shadow">
                            <p>Project: {{ $request->project->title }}</p>
                            <p>Email: {{ Auth::user()->role === 'CLIENT' ? $request->designer->email : $request->client->email }}</p>
                            <p>Status: {{ ucfirst($request->project->status) }}</p>
                            {{-- Additional logic for accepting/rejecting requests if needed --}}
                        </div>
                    @empty
                        <p>No collaboration requests found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
