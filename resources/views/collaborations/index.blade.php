<!-- index.blade.php -->

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

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                @if(Auth::user()->role === 'CLIENT')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designer Email</th>
                                @else
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client Email</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Status</th> <!-- New Column -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($collaborationRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->project_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->project->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ Auth::user()->role === 'CLIENT' ? $request->designer->email : $request->client->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(Auth::user()->role === 'CLIENT')
                                            @if($request->status === 'pending')
                                                <form action="{{ route('collaborations.update', $request->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="accepted" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
                                                    <button type="submit" name="status" value="rejected" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</button>
                                                </form>
                                            @else
                                                {{ ucfirst($request->status) }}
                                            @endif
                                        @else
                                            {{ ucfirst($request->status) }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->project->status }}</td> <!-- Display Project Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('projects.edit', $request->project_id) }}" class="bg-blue-500 text-white px-4 py-3 rounded hover:bg-blue-600">Edit</a>
                                        <a href="{{ route('finances.show', $request->project_id) }}" class="bg-green-500 text-white px-4 py-3 rounded hover:bg-green-600">View Finance</a>
                                        <form action="{{ route('collaborations.destroy', $request->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-2.5 rounded hover:bg-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap">No collaboration requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
