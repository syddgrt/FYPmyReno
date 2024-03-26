<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($portfolio->items as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            @if ($item->type === 'image')
                                <img src="{{ Storage::url($item->content) }}" alt="Portfolio Image" class="w-full h-auto mb-4">
                            @elseif ($item->type === 'text')
                                <p class="mb-4">{{ $item->content }}</p>
                            @endif
                            <h3 class="text-xl font-semibold">{{ $item->title }}</h3>
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
