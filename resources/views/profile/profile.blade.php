<!-- profile.blade.php -->
<div>
    <h2>{{ $profileUser->name }}</h2>
    <p>Email: {{ $profileUser->email }}</p>
    <!-- Add a link to start a conversation -->
    <a href="{{ route('conversations.index', ['recipientId' => $profileUser->id]) }}">Start Conversation</a>
</div>
