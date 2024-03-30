<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(Auth::user()->role === 'CLIENT')
                {{ __('My Collaboration Requests') }}
            @else
                {{ __('Collaboration Requests') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Collaboration Requests</h1>

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
</x-app-layout>
