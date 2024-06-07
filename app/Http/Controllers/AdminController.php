<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\User;
use App\Models\FinancialData;
use App\Models\Collaborations;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'You do not have admin access.']);
            }
        }

        // Authentication failed
        return redirect()->route('admin.login')->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    

    public function dashboard()
{
    // Retrieve projects grouped by their creation date
    $projectsByDate = Projects::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Prepare data for project chart
    $projectDates = $projectsByDate->pluck('date')->map(function ($date) {
        return Carbon::parse($date)->format('Y-m-d');
    });
    $projectCounts = $projectsByDate->pluck('count');

    // Combine project dates and counts into a single array
    $projectChartData = [];
    foreach ($projectDates as $index => $date) {
        $projectChartData[] = [
            'date' => $date,
            'count' => $projectCounts[$index],
        ];
    }

    // Retrieve users grouped by their creation month
    $usersByMonth = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    // Prepare data for user chart
    $timeframes = $usersByMonth->map(function ($user) {
        return Carbon::createFromDate($user->year, $user->month)->format('M Y');
    });
    $userCounts = $usersByMonth->pluck('count');

    // Combine timeframes and user counts into a single array
    $userData = [];
    foreach ($timeframes as $index => $timeframe) {
        $userData[] = [
            'timeframe' => $timeframe,
            'count' => $userCounts[$index],
        ];
    }

    return view('admin.dashboard', [
        'projectChartData' => $projectChartData,
        'userData' => $userData,
    ]);
}



    public function collaborations()
    {
        $collaborations = Collaborations::with(['client', 'designer', 'project'])->get(); // Eager load client and designer relationships

        return view('admin.collaborations', ['collaborations' => $collaborations]);
    }

    public function destroyCollaboration($id)
    {
        $collaboration = Collaborations::findOrFail($id);
        $collaboration->delete();

        return redirect()->route('admin.collaborations')->with('success', 'Collaboration deleted successfully.');
    }

    public function finances()
    {
        $finances = FinancialData::all(); // Retrieve all finance records from the database

        return view('admin.finances', ['finances' => $finances]);
    }

    public function destroyFinancialData($id)
    {
        $finances = FinancialData::findOrFail($id);
        $finances->delete();

        return redirect()->route('admin.finances')->with('success', 'Financial Data deleted successfully.');
    }

    public function messages()
    {
        $id = 1; // Replace 1 with the actual value or retrieve it from your database
        $messengerColor = '#007bff'; // Example color
        $dark_mode = false; // Example dark mode status

        return view('admin.messages', compact('id', 'messengerColor', 'dark_mode'));
    }


    public function projects()
    {
        // Eager load the 'client' and 'designer' relationships
        $projects = Projects::with(['client', 'designer'])->get();

        return view('admin.projects', ['projects' => $projects]);
    }

    public function destroyProjects($id)
    {
        $project = Projects::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Project deleted successfully.');
    }

    public function users()
    {
        $users = User::all(); // Retrieve all users from the database

        return view('admin.users', ['users' => $users]);
    }
}
