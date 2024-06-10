<x-app-layout class="bg-gray-200">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="mt-2 flex items-center">
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">{{ $userRole }}</span>
        </div>
    </x-slot>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="bg-gray-300 text-gray-600 px-2.5 py-1.5 rounded-full uppercase text-xs font-bold mb-4">Welcome to the MyReno Guide</h1>

        @if($userRole === 'CLIENT')
            <!-- For Clients -->
            <h2 class="bg-gray-300 text-gray-600 px-2.5 py-1.5 rounded text-lg font-semibold mb-2">For Clients:</h2>
            <div class="space-y-4">
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Creating Projects:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Clients can navigate to the projects page.</li>
                        <li>Clients can then click on "Create New Project" or search for their already created projects.</li>
                        <li>Fill in the form to create a new project.</li>
                        <li>Clients can then choose to edit or delete the projects.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Initiating Collaborations:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Once the project has been created, designers can view the projects and send collaboration requests.</li>
                        <li>Clients can then choose to accept or decline these collaboration requests.</li>
                        <li>After accepting a collaboration from a designer, designers can update the financial data.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Searching for Designers:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Clients can search for and view available designers on the platform.</li>
                        <li>Clients can view designers' portfolios and initiate conversations (chat with the designer).</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Monitoring Financial Information:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Clients cannot create their own financial data, only designers can.</li>
                        <li>Clients can generate reports and invoices from the financial data input by the designer for a particular project.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Messages System:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Clients can engage in real-time messaging with designers on the app.</li>
                        <li>Clients can share attachments and uploads on the app.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Scheduling and Viewing Appointments:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Clients can set or view appointments submitted by the designer they collaborate with.</li>
                    </ul>
                </div>
            </div>

        @elseif($userRole === 'DESIGNER')
            <!-- For Designers -->
            <h2 class="bg-gray-300 text-gray-600 px-2.5 py-1.5 rounded text-lg font-semibold mb-2">For Designers:</h2>
            
            <div class="space-y-4">
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Initiating Collaborations:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Designers can request collaboration when viewing available projects on the system.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Creating and Modifying Portfolios:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Designers can modify their portfolio by clicking on "Modify Portfolio".</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Using the message system:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Designers can engage in real-time messaging with clients on the app.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Monitoring Client's Project Financial Data:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Designers can create financial data for a project they collaborate on by clicking on "Add Financial Data".</li>
                        <li>Designers can generate financial data into invoices.</li>
                    </ul>
                </div>
                <div class="bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    <p class="font-semibold">Scheduling and Viewing Appointments:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Designers can schedule appointments with clients.</li>
                        <li>Designers can view created appointments with clients.</li>
                    </ul>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
