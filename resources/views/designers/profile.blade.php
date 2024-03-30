<x-app-layout>
    <h1>{{ $designer->name }}</h1>
    <!-- Display other details of the designer -->

    <!-- Add button to start conversation -->
    <form method="POST" action="{{ route('conversations.start', ['recipientId' => $designer->id]) }}">
        @csrf
        <button type="submit">Start Conversation</button>
    </form>
</x-app-layout>
