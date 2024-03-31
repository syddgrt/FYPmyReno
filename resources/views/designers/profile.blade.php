<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $designer->name }}</h1>
                    <!-- Display other details of the designer -->
                    <p class="text-gray-600 dark:text-gray-400">{{ $designer->email }}</p>
                    <!-- Add more designer information here as needed -->
                </div>

                <!-- Add button to start conversation -->
                <form method="POST" action="{{ route('conversations.start', ['recipientId' => $designer->id]) }}" class="mb-4">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition duration-300">
                        Start Conversation
                    </button>
                </form>

                <!-- Portfolio Section -->
                <div class="portfolio">
                    <h2 class="text-xl font-semibold mb-4">Portfolio</h2>

                    
                    @if ($designer->portfolio)
                        <div class="grid grid-cols-2 gap-4">
                            @forelse ($designer->portfolio->items as $item)
                                <div class="overflow-hidden shadow-lg rounded-lg">
                                    <img src="{{ Storage::url($item->content) }}" alt="Portfolio item" class="w-full h-auto">
                                    <!-- Add additional item details if necessary -->
                                </div>
                            @empty
                                <p>No portfolio items found.</p>
                            @endforelse
                        </div>
                    @else
                        <p>No portfolio available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
