<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="mt-2 flex items-center">
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">{{ $userRole }}</span>
        </div>

        <!-- Add button for accessing messages -->
        <div class="mt-4">
            <a href="{{ route('conversations.index', ['recipientId' => $defaultRecipientId ?? null]) }}" class="bg-blue-500 text-white py-2 px-4 rounded">Messages</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-2 gap-4">
                <!-- Link to Projects -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="font-semibold text-lg mb-2">Projects</h3>
                        <p class="text-sm">Manage or edit your current active projects.</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('projects.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Projects</a>
                    </div>
                </div>
                @if($userRole === 'CLIENT')
                <!-- Link to Designers -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="font-semibold text-lg mb-2">Designers</h3>
                        <p class="text-sm">Explore available designers to help in your home deco journey</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('designers.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Designers</a>
                    </div>
                </div>
                    <!-- Link to Finances -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="font-semibold text-lg mb-2">Finances</h3>
                            <p class="text-sm">View financial information and analytics.</p>
                        </div>
                        <div class="p-6">
                            <a href="{{ route('finances.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Finances</a>
                        </div>
                    </div>
                    <!-- Link to Collaborations -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="font-semibold text-lg mb-2">Collaborations</h3>
                            <p class="text-sm">Manage collaboration requests with agreeable designers.</p>
                        </div>
                        <div class="p-6">
                            <a href="{{ route('collaborations.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Collaborations</a>
                        </div>
                    </div>
                @elseif($userRole === 'DESIGNER')
                    <!-- Link to Portfolio -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="font-semibold text-lg mb-2">Portfolio</h3>
                            <p class="text-sm">Modify your portfolio to showcase your work.</p>
                        </div>
                        <div class="p-6">
                            <a href="{{ route('portfolios.modify') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modify Portfolio</a>
                        </div>
                    </div>
                    <!-- Link to Collaborations -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="font-semibold text-lg mb-2">Collaborations</h3>
                            <p class="text-sm">Manage collaboration requests with agreeable designers.</p>
                        </div>
                        <div class="p-6">
                            <a href="{{ route('collaborations.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Collaborations</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
