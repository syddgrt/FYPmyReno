<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->role === 'CLIENT' ? __('My Collaborations') : __('Active Collaborations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ Auth::user()->role === 'CLIENT' ? 'My Collaborations' : 'My Collaborations' }}</h1>

                    <form method="GET" action="{{ route('collaborations.index') }}" class="mb-4">
                        <div class="flex items-center">
                            <input type="text" name="client_name" placeholder="Search by Client Name" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ request('client_name') }}">
                            <button type="submit" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
                        </div>
                    </form>

                    <table class="table-auto border-collapse border border-gray-800 w-full">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Project ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Project</th>
                                @if(Auth::user()->role === 'CLIENT')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Designer Email</th>
                                @else
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Client Email</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Project Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-1000 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($collaborationRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->project_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->project->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ Auth::user()->role === 'CLIENT' ? $request->designer->email : $request->client->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($request->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->project->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">

                                    @if ($request->status === 'pending' && Auth::user()->role === 'CLIENT')
                                            <form action="{{ route('collaborations.update', $request->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status" value="accepted" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Accept</button>
                                                <button type="submit" name="status" value="denied" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Reject</button>
                                            </form>
                                    @elseif($request->status === 'accepted')
                                        <a href="{{ route('projects.edit', $request->project_id) }}" class="fa fa-edit bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"></a>
                                        @if($userRole === 'DESIGNER')
                                            @if($request->project->financialData)
                                                <a href="{{ route('finances.show', $request->project_id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">View Finance</a>
                                            @else
                                                <a href="{{ route('finances.create', ['project_id' => $request->project_id]) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create Finance</a>
                                            @endif

                                            @if($request->appointment)
                                                <a href="{{ route('appointments.show', $request->appointment->id) }}" class="bg-yellow-500 text-white px-2 py-2 rounded hover:bg-yellow-600">
                                                    View Appointment
                                                </a>
                                            @else
                                                <a href="{{ route('appointments.create', ['collaboration_id' => $request->id, 'project_id' => $request->project_id]) }}" class="bg-yellow-500 text-white px-2 py-2 rounded hover:bg-yellow-600">
                                                    Set Appointment
                                                </a>
                                            @endif
                                        @elseif($userRole === 'CLIENT')
                                            @if($request->project->financialData)
                                                <a href="{{ route('finances.show', $request->project_id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">View Finance</a>
                                            @endif

                                            @if($request->appointment)
                                                <a href="{{ route('appointments.show', $request->appointment->id) }}" class="bg-yellow-500 text-white px-2 py-2 rounded hover:bg-yellow-600">
                                                    View Appointment
                                                </a>
                                            @endif
                                        @endif
                                    @endif
                                    

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
