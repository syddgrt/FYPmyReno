<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($designer->portfolio)
                <div class="mb-4 grid grid-cols-1 gap-4">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $designer->name }}</h1>
                    <!-- Display other details of the designer -->
                    <p class="text font-bold text-white-600 dark:text-gray-200">{{ $designer->email }}</p>
                    <!-- Add more designer information here as needed -->
                    <div>
                        <p class="text-white-600 dark:text-gray-200">{{ $designer->portfolio->title }}</p>
                        <p class="text-white-600 dark:text-gray-400">{{ $designer->portfolio->description }}</p>
                    </div>
                    <!-- Display specializations with colored rectangles -->
                    <div class="mt-4">
                        @php
                            $specializationColors = [
                                'contemporary' => 'bg-red-500',
                                'modern' => 'bg-green-500',
                                'classic' => 'bg-blue-500',
                                'minimalist' => 'bg-yellow-500',
                                'rustic' => 'bg-purple-500'
                            ];
                        @endphp
                        @if ($designer->portfolio && isset($designer->portfolio->specialization) && is_array($designer->portfolio->specialization))
                            @foreach ($designer->portfolio->specialization as $specialization)
                                <span class="inline-block px-2 py-1 text-white rounded {{ $specializationColors[$specialization] ?? 'bg-gray-500' }}">
                                    {{ ucfirst($specialization) }}
                                </span>
                            @endforeach
                        @else
                            <span class="inline-block px-2 py-1 text-white rounded bg-gray-500">No Specialization</span>
                        @endif
                    </div>
                </div>
                
                <!-- Modify the form to use a GET request and redirect to the Chatify URL -->
                <form method="GET" action="{{ url('messenger/' . $designer->id) }}" class="mb-4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition duration-300">Start Conversation</button>
                </form>
                
                <!-- Display portfolio items -->
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
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-blue-500 border-b border-gray-200 rounded-lg">
                            <h3 class="text-lg font-bold mb-4">Reviews</h3>
                            @if ($designer->reviewsReceived->isEmpty())
                                <p class="text-gray-600">No reviews available.</p>
                            @else
                                @foreach ($designer->reviewsReceived as $review)
                                    <div class="mb-4 border rounded p-4 bg-white">
                                        <h4 class="font-bold">Project: {{ $review->project->title }}</h4>
                                        <div class="flex items-center">
                                            <p class="text-gray-600">Rating:</p>
                                            <div class="flex ml-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 0l2.65 7.682 7.35.184-5.613 4.515L15.457 20 10 15.682 4.543 20l1.975-7.619-5.613-4.515 7.35-.184L10 0z"/>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 0l2.65 7.682 7.350  .35L15.457 20 10 15.682 4.543 20l1.975-7.619-5.613-4.515 7.35-.184L10 0z"/>
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-600">Feedback: {{ $review->feedback }}</p>
                                        <p class="text-gray-500 text-sm">Reviewed by: {{ $review->client->name }} on {{ $review->created_at->format('d M Y') }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
