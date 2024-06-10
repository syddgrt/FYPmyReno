<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Available Designers
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('designers.index') }}" method="GET">
                <div class="mb-4">
                    <input type="text" name="search" class="px-4 py-2 border border-gray-300 rounded-md" placeholder="Search Designers..." value="{{ $search ?? '' }}">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                </div>
            </form>

            <!-- Filter by Specialization -->
            <!-- <div class="mb-4">
                <span class="text-gray-700">Filter by Specialization:</span>
                @php
                    $specializations = ['contemporary', 'modern', 'classic', 'minimalist', 'rustic'];
                @endphp
                @foreach ($specializations as $spec)
                    <label class="inline-flex items-center ml-2">
                        <input type="checkbox" name="specialization[]" value="{{ $spec }}" class="form-checkbox h-5 w-5 text-blue-600"><span class="ml-2 text-gray-700">{{ ucfirst($spec) }}</span>
                    </label>
                @endforeach
            </div> -->

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
                @foreach ($designers as $designer)
                    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg sm:rounded-lg p-4 hover:shadow-2xl transition-shadow duration-300">
                        <a href="{{ route('designers.portfolio', $designer->id) }}" class="text-lg font-semibold hover:underline text-gray-800 dark:text-gray-100">{{ $designer->name }}</a>
                        <p class="text-gray-600 dark:text-gray-400">{{ $designer->email }}</p>
                        <!-- Display specializations -->
                        <div class="mt-2">
                            @if ($designer->portfolio && isset($designer->portfolio->specialization))
                                @php
                                    $specializationColors = [
                                        'contemporary' => 'bg-red-500',
                                        'modern' => 'bg-green-500',
                                        'classic' => 'bg-blue-500',
                                        'minimalist' => 'bg-yellow-500',
                                        'rustic' => 'bg-purple-500'
                                    ];
                                @endphp
                                @foreach ($designer->portfolio->specialization as $specialization)
                                    <span class="inline-block px-2 py-1 text-white rounded {{ $specializationColors[$specialization] ?? 'bg-gray-500' }}">{{ ucfirst($specialization) }}</span>
                                @endforeach
                            @else
                                <span class="inline-block px-2 py-1 text-white rounded bg-gray-500">No Specialization</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
