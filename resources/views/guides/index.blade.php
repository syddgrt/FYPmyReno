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
            <h2 class="bg-gray-300 text-gray-600 px-2.5 py-1.5 rounded-full uppercase text-xs font-bold mr-2">For Clients:</h2>
            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Creating Projects:</span></p>
            <ol>
                <li><span class="text-gray-500">Clients can navigate to the projects page.</span></li>
                <li><span class="text-gray-500">Clients can then click on "Create New Project" or search for their already created projects.</span></li>
                <li><span class="text-gray-500">Fill in the form to create a new project.</span></li>
                <li><span class="text-gray-500">Clients can then choose to edit or delete the projects.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Initiating Collaborations:</span></p>
            <ol>
                <li><span class="text-gray-500">Once the project has been created, designers can view the projects and send collaboration requests.</span></li>
                <li><span class="text-gray-500">Clients can then choose to accept or decline these collaboration requests.</span></li>
                <li><span class="text-gray-500">After accepting a collaboration from a designer, designers can update the financial data.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Searching for Designers:</span></p>
            <ol>
                <li><span class="text-gray-500">Clients can search for and view available designers on the platform.</span></li>
                <li><span class="text-gray-500">Clients can view designers' portfolios and initiate conversations (chat with the designer).</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Monitoring Financial Information:</span></p>
            <ol>
                <li><span class="text-gray-500">Clients cannot create their own financial data, only designers can.</span></li>
                <li><span class="text-gray-500">Clients can generate reports and invoices from the financial data input by the designer for a particular project.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Messages System:</span></p>
            <ol>
                <li><span class="text-gray-500">Clients can engage in real-time messaging with designers on the app.</span></li>
                <li><span class="text-gray-500">Clients can share attachments and uploads on the app.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Scheduling and Viewing Appointments:</span></p>
            <ol>
                <li><span class="text-gray-500">Clients can set or view appointments submitted by the designer they collaborate with.</span></li>
            </ol>

        @elseif($userRole === 'DESIGNER')
            <!-- For Designers -->
            <h2 class="text-lg font-semibold mb-2">For Designers:</h2>
            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Initiating Collaborations:</span></p>
            <ol>
                <li><span class="text-gray-500">Designers can request collaboration when viewing available projects on the system.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Creating and Modifying Portfolios:</span></p>
            <ol>
                <li><span class="text-gray-500">Designers can modify their portfolio by clicking on "Modify Portfolio".</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Using the message system:</span></p>
            <ol>
                <li><span class="text-gray-500">Designers can engage in real-time messaging with clients on the app.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Monitoring Client's Project Financial Data:</span></p>
            <ol>
                <li><span class="text-gray-500">Designers can create financial data for a project they collaborate on by clicking on "Add Financial Data".</span></li>
                <li><span class="text-gray-500">Designers can generate financial data into invoices.</span></li>
            </ol>

            <p><span class="bg-gray-400 text-gray-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">Scheduling and Viewing Appointments:</span></p>
            <ol>
                <li><span class="text-gray-500">Designers can schedule appointments with clients.</span></li>
                <li><span class="text-gray-500">Designers can view created appointments with clients.</span></li>
            </ol>

        @endif

    </div>
</x-app-layout>
