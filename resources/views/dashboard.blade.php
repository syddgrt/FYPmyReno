<head><style>
        .status {
            margin-top: 3px;
            padding: 2px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px; /* full rounded */
            display: inline-flex;
            align-items: center;
        }
        .bg-red-300 { background-color: #fc8181; }
        .text-red-800 { color: #742a2a; }
        .bg-yellow-300 { background-color: #faf089; }
        .text-yellow-800 { color: #7b341e; }
        .bg-green-300 { background-color: #9ae6b4; }
        .text-green-800 { color: #22543d; }

        /* Adjusted container size for charts */
    /* Adjusted container size for charts */
    .chart-container {
        display: grid;
        grid-template-columns: 30% 70%; /* Adjust the percentages as needed */
    }

    .chart-wrapper-1, .chart-wrapper-2 {
        width: 98%;
        height: 400px; /* Adjust the height as needed */
    }
        

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<title>Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="mt-2 flex items-center">
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full uppercase text-xs font-bold mr-2">{{ $userRole }}</span>
        </div>
    </x-slot>
    

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">   
    <div class="grid grid-cols-4 md:grid-cols-4 lg:grid-cols-2 gap-4">
            @if($userRole === 'CLIENT')
            <!-- Total Designers -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-2">Total Designers</h3>
                    <p class="text-sm">Number of designers currently registered in the system.</p>
                    <p class="text-3xl font-bold text-center ">{{ $designerCount }}</p>
                    
                </div>
            </div>
            @endif

            @if($userRole === 'DESIGNER')
            <!-- Total Clients -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-2">Total Clients</h3>
                    <p class="text-sm">Number of clients currently registered in the system.</p>
                    <p class="mt-2 text-3xl font-bold text-center">{{ $clientCount }}</p>
                </div>
            </div>
            @endif

            <!-- Number of Collaborations -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-2">Number of Collaborations</h3>
                    <p class="text-sm">Total number of projects you are collaborating on.</p>
                    <p class="mt-2 text-3xl font-bold text-center">{{ $activeCollaborations->count() }}</p>
                </div>
            </div>
        </div>   
        <div class="chart-container grid gap-4 mb-4">
            <!-- Donut Chart for Project Status -->
            <div class="chart-wrapper-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-2">Project Status</h3>
                    <canvas id="projectStatusChart"></canvas>
                </div>
            </div>

                <!-- Time-Series Chart -->
            <div class="chart-wrapper-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-2">Active Collaborations in the System</h3>
                    <canvas id="collaborationsChart" style="max-height: 320px;"></canvas>
                </div>
            </div>

        </div>
            <div class="grid grid-cols-4 md:grid-cols-4 lg:grid-cols-2 gap-4">
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
                @endif

                <!-- Common Links for Clients and Designers -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="font-semibold text-lg mb-2">Finances</h3>
                        <p class="text-sm">View financial information and analytics.</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('finances.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Finances</a>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="font-semibold text-lg mb-2">Collaborations</h3>
                        <p class="text-sm">Manage collaboration requests with agreeable designers.</p>
                    </div>
                    <div class="p-6">
                        <a href="{{ route('collaborations.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Collaborations</a>
                    </div>
                </div>
                
                @if($userRole === 'DESIGNER')
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
                @endif
            </div>
            @if($userRole === 'CLIENT')
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-1 gap-4 mt-4">
                <!-- Card for Active Collaborations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="font-semibold text-lg mb-2">Active Collaborations</h3>
                        @if($activeCollaborations->isEmpty())
                            <p class="text-sm">No active collaborations at the moment.</p>
                        @else
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($activeCollaborations as $project)
                                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                        <p><strong>Project:</strong> {{ $project->title }}</p>
                                        <span class="status
                                            @if ($project->status === 'Pending') bg-red-300 text-red-800 
                                            @elseif ($project->status === 'In View') bg-yellow-300 text-yellow-800 
                                            @elseif ($project->status === 'Finished') bg-green-300 text-green-800 
                                            @endif">
                                            {{ $project->status }}
                                        </span>
                                        @if($project->financialData)
                                            <p><strong>Cost Estimation: RM</strong> {{$project->financialData->actual_cost }}</p>
                                        @else
                                            <p><strong>Cost Estimation:</strong> Not Available</p>
                                        @endif

                                        @if($project->collaborations->isNotEmpty())
                                            @foreach($project->collaborations as $collaboration)
                                                @if($collaboration->projectSchedules->isNotEmpty())
                                                    <strong>Appointment:</strong>
                                                    <ul class="ml">
                                                        @foreach($collaboration->projectSchedules as $schedule)
                                                            <li class="mb-2">
                                                                <div class="flex items-center">
                                                                    <div class="rounded-full bg-blue-500 text-white px-3 py-1 mr-2">
                                                                        {{ \Carbon\Carbon::parse($schedule->date)->format('d - F - Y') }}
                                                                    </div>
                                                                    <div class="rounded-full bg-gray-500 text-white px-3 py-1 mr-2">
                                                                        {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}
                                                                    </div>
                                                                    <div class="rounded-full bg-green-500 text-white px-3 py-1 mr-2">
                                                                        {{($schedule->place)}}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @elseif($userRole === 'DESIGNER')
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-1 gap-4 mt-4">
                <!-- Card for Active Collaborations -->
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <h3 class="font-semibold text-lg mb-2">Active Collaborations</h3>
                        @if($activeCollaborations->isEmpty())
                            <p class="text-sm">No active collaborations at the moment.</p>
                        @else
                            <div class="grid grid-cols-1 gap-4">
                                
                            @foreach($activeCollaborations as $collaboration)
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <div>
                                            <p class="text-lg font-semibold">{{ $collaboration->project->title }}</p>
                                            <p class="text-sm text-green-600">{{ $collaboration->project->user->name }}</p>
                                        </div>
                                        <span class="status
                                            @if ($collaboration->project->status === 'Pending') bg-red-300 text-red-800 
                                            @elseif ($collaboration->project->status === 'In View') bg-yellow-300 text-yellow-800 
                                            @elseif ($collaboration->project->status === 'Finished') bg-green-300 text-green-800 
                                            @endif">
                                            {{ $collaboration->project->status }}
                                        </span>
                                    </div>
                                    @if($collaboration->project->financialData)
                                        <p><strong>Cost Estimation:</strong> RM {{$collaboration->project->financialData->actual_cost }}</p>
                                    @else
                                        <p><strong>Cost Estimation:</strong> Not Available</p>
                                    @endif

                                    @if($collaboration->projectSchedules && $collaboration->projectSchedules->isNotEmpty())
                                        <strong>Appointments:</strong>
                                        <ul class="ml-4">
                                            @foreach($collaboration->projectSchedules as $schedule)
                                                <li class="mb-2">
                                                    <div class="flex items-center">
                                                        <div class="rounded-full bg-blue-500 text-white px-3 py-1 mr-2">
                                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d - F - Y') }}
                                                        </div>
                                                        <div class="rounded-full bg-gray-500 text-white px-3 py-1 mr-2">
                                                            {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}
                                                        </div>
                                                        <div class="rounded-full bg-green-500 text-white px-3 py-1 mr-2">
                                                            {{ $schedule->place }}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach

                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            


        </div>
    </div>

    <script>
        // Data for Project Status Donut Chart
const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
const projectStatusLabels = {!! json_encode($projectStatus->pluck('status')->toArray()) !!};
const projectStatusCounts = {!! json_encode($projectStatus->pluck('count')->toArray()) !!};

const projectStatusChart = new Chart(projectStatusCtx, {
    type: 'doughnut',
    data: {
        labels: projectStatusLabels,
        datasets: [{
            label: 'Project Status',
            data: projectStatusCounts,
            backgroundColor: ['#fc8181', '#faf089', '#9ae6b4'],
            hoverOffset: 4
        }]
    }
});


        // Data for Collaborations Over Time Chart
        const collaborationsCtx = document.getElementById('collaborationsChart').getContext('2d');
        const collaborationDates = {!! json_encode($collaborations->pluck('date')->toArray()) !!};
        const collaborationCounts = {!! json_encode($collaborations->pluck('count')->toArray()) !!};

        const collaborationsChart = new Chart(collaborationsCtx, {
            type: 'line',
            data: {
                labels: collaborationDates,
                datasets: [{
                    label: 'Collaborations',
                    data: collaborationCounts,
                    borderColor: '#42a5f5',
                    fill: false,
                    tension: 0.1
                }]
            }
        });


    </script>
</x-app-layout>
