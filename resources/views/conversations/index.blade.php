<!-- resources/views/conversations/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Conversations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Your Conversations</h3>
                    @if ($conversations->isEmpty())
                        <p>No conversations found.</p>
                    @else
                        <ul>
                            @foreach ($conversations as $conversation)
                                <li class="mb-4">
                                    <a href="{{ route('conversations.show', $conversation) }}" class="text-blue-500 hover:underline">
                                        Conversation with {{ $conversation->users->except(Auth::id())->first()->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">{{ $conversation->messages->last()->body }}</p>
                                    <p class="text-xs text-gray-400">{{ $conversation->messages->last()->created_at->diffForHumans() }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Message Form -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Send Message</h3>
                        @if($recipientId)
                            <form action="{{ route('messages.send', $recipientId) }}" method="POST">
                                @csrf
                                <textarea name="message" rows="3" class="w-full border border-gray-300 rounded-md p-2 mb-4" placeholder="Type your message here..." required></textarea>
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Send</button>
                            </form>
                        @else
                            <p>No active conversations available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
