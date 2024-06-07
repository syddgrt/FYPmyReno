<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Show Portfolio') }}
                <div class="mt-4">
                    <a href="{{ route('portfolios.modify') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded">Modify Portfolio</a>
                </div>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Portfolio Title and Description -->
            <div class="mb-8">
                <h1 class="text-2xl text-white font-bold">{{ $portfolio->title }}</h1>
                <p class="mt-4 text-white">{{ $portfolio->description }}</p>
            </div>
            <!-- Specializations -->
            <div class="mb-8">
                <h3 class="text-xl text-white font-semibold mb-4">Specializations</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $portfolio->specialization) as $specialization)
                        <span class="px-3 py-1 rounded-full text-white font-semibold {{ getSpecializationColor($specialization) }}">
                            {{ ucfirst($specialization) }}
                        </span>
                    @endforeach
                </div>
            </div>
            <!-- Portfolio Items -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($portfolio->items as $item)
                    <div class="bg-white dark:bg-white-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            @if ($item->type === 'image')
                                <img src="{{ Storage::url($item->content) }}" alt="Portfolio Image" class="w-full h-auto mb-4" onclick="openModal('{{ Storage::url($item->content) }}')">
                            @elseif ($item->type === 'text')
                                <p class="mb-4">{{ $item->content }}</p>
                            @endif
                            <h3 class="text-xl font-semibold">{{ $item->title }}</h3>
                            <p>{{ $item->description }}</p>
                            <!-- Delete Button -->
                            <form action="{{ route('portfolio.items.delete', ['item' => $item->id]) }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete Item</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal for full-size image view -->
    <div id="imageModal" class="hidden fixed z-50 left-0 top-0 w-full h-full overflow-auto bg-black bg-opacity-50">
        <div class="modal-content container mx-auto lg:w-1/2 xl:w-1/3 p-5">
            <span class="close cursor-pointer text-white text-2xl float-right">&times;</span>
            <img id="fullSizeImage" src="" class="w-full h-auto">
        </div>
    </div>

    <script>
        function openModal(imageUrl) {
            document.getElementById('fullSizeImage').src = imageUrl;
            document.getElementById('imageModal').style.display = 'block';
        }

        document.querySelector('#imageModal .close').addEventListener('click', function() {
            document.getElementById('imageModal').style.display = 'none';
        });
    </script>
</x-app-layout>
