<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Financial Data
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    
                    <!-- Filter Form for Designers -->
                    @if(auth()->user()->role == 'DESIGNER')
                        <form method="GET" class="mb-4">
                            <div class="flex items-center mb-4">
                                <label for="client_id" class="mr-2">Filter by Client:</label>
                                <select name="client_id" id="client_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Clients</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $clientId ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    @endif


                    <!-- Form for Creating Financial Data -->
                    <form action="{{ route('finances.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Project Selection -->
                            <div>
                                <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                                <select id="project_id" name="project_id" class="mt-1 block w-full text-black focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @foreach($projects as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Display Project Details -->
                            <div id="projectDetailsContainer" class="hidden">
                                <h3 class="text-lg font-semibold mt-4">Project Details</h3>
                                <p id="projectTitle" class="text-gray-700"></p>
                                <p id="projectDescription" class="text-gray-700"></p>
                                <!-- Add more project details here -->
                            </div>

                            <!-- Cost Estimation (Visible to all users) -->
                            <div>
                                <label for="cost_estimation" class="block text-sm font-medium text-gray-700">Proposed Cost (RM)</label>
                                <input type="number" name="cost_estimation" id="cost_estimation" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Additional fields for designers -->
                            @if(auth()->user()->role == 'DESIGNER')
                                <!-- Actual Cost -->
                                <div>
                                    <label for="actual_cost" class="block text-sm font-medium text-gray-700">Estimation Cost (RM)</label>
                                    <input type="number" name="actual_cost" id="actual_cost" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Tax -->
                                <div>
                                    <label for="tax" class="block text-sm font-medium text-gray-700">Tax (RM)</label>
                                    <input type="number" name="tax" id="tax" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Additional Fees -->
                                <div>
                                    <label for="additional_fees" class="block text-sm font-medium text-gray-700">Additional Fees (RM)</label>
                                    <input type="number" name="additional_fees" id="additional_fees" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clientDropdown = document.getElementById('client_id');
            const projectDropdown = document.getElementById('project_id');

            clientDropdown.addEventListener('change', function () {
                const selectedClientId = this.value;
                fetch(`/finances/create?client_id=${selectedClientId}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newProjectDropdown = doc.getElementById('project_id');
                        projectDropdown.innerHTML = newProjectDropdown.innerHTML;
                    });
            });
        });

        clientDropdown.addEventListener('change', function () {
            const selectedClientId = this.value;
            fetch(`/finances/create?client_id=${selectedClientId}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProjectDropdown = doc.getElementById('project_id');
                    const clientBudget = doc.getElementById('clientBudget').innerText; // Get client budget text
                    projectDropdown.innerHTML = newProjectDropdown.innerHTML;
                    document.getElementById('clientBudget').innerText = "Client Budget: RM " + clientBudget; // Update client budget text
                });
        });

    </script>
</x-app-layout>
