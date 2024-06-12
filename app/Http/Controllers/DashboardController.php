<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Import the correct Request class
use App\Models\Projects; // Assuming Project model exists
use App\Models\User;
use App\Models\Collaborations;
use App\Models\FinancialData;
use App\Models\Schedules;

class DashboardController extends Controller{

    public function index()
{
    $user = Auth::user();
    $userRole = $user->role;

    // Initialize variables to hold chart data
    $projectStatus = [];
    $collaborations = [];

    if ($userRole === 'CLIENT') {
        // Fetch projects with active collaborations for clients
        $activeCollaborations = Projects::where('user_id', $user->id)
            ->whereHas('collaborations', function($query) {
                $query->where('status', 'accepted');
            })
            ->with(['collaborations' => function($query) {
                $query->where('status', 'accepted')
                    ->with('projectSchedules');
            }, 'financialData'])
            ->get();

        // Fetch project status data for the client
        $projectStatus = Projects::selectRaw('status, COUNT(*) as count')
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->get();

        // Fetch collaborations over time for the client
        $collaborations = Collaborations::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereHas('project', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'accepted') // Filter by collaboration status
            ->groupBy('date')
            ->get();

        // Count the number of designers
        $designerCount = User::where('role', 'DESIGNER')->count();
        $clientCount = User::where('role', 'CLIENT')->count();
    } elseif ($userRole === 'DESIGNER') {
        // Fetch active collaborations for designers
        $activeCollaborations = Collaborations::where('designer_id', $user->id)
            ->where('status', 'accepted')
            ->with(['project' => function($query) {
                $query->with(['financialData', 'collaborations.projectSchedules']);
            }, 'projectSchedules']) // Load project schedules directly from collaborations
            ->get();

        // Fetch project status data for the designer
        $projectStatus = Projects::selectRaw('status, COUNT(*) as count')
            ->whereHas('collaborations', function ($query) use ($user) {
                $query->where('designer_id', $user->id)
                    ->where('status', 'accepted');
            })
            ->groupBy('status')
            ->get();

        // Fetch collaborations over time for the designer
        $collaborations = Collaborations::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('designer_id', $user->id)
            ->where('status', 'accepted') // Filter by collaboration status
            ->groupBy('date')
            ->get();

        // Count the number of designers
        $designerCount = User::where('role', 'DESIGNER')->count();
        $clientCount = User::where('role', 'CLIENT')->count();
    }

    // Render the dashboard view with the appropriate data
    return view('dashboard', [
        'userRole' => $userRole,
        'activeCollaborations' => $activeCollaborations,
        'designerCount' => $designerCount ?? 0, // Set default value if not defined
        'clientCount' => $clientCount ?? 0, // Set default value if not defined
        'collaborations' => $collaborations,
        'projectStatus' => $projectStatus,
    ]);
}




public function showDesigners(Request $request)
{
    // Fetch all designers along with their portfolios
    $designersQuery = User::where('role', 'DESIGNER')->with('portfolio');

    // Filter by search query
    $search = $request->input('search');
    if ($search) {
        $designersQuery->where('name', 'like', '%' . $search . '%');
    }

    $designers = $designersQuery->get();

    // Parse the specialization data into an array
    $designers->each(function ($designer) {
        if ($designer->portfolio) {
            $designer->portfolio->specialization = explode(',', $designer->portfolio->specialization);
        }
    });

    return view('designers.index', compact('designers', 'search'));
}



    public function showPortfolio(User $designer)
    {
        // Assuming there's a relationship between User and Portfolio
        $portfolio = $designer->portfolio;

        if ($portfolio) {
            // Load the portfolio items if needed
            $portfolio->load('items');
            return view('portfolios.show', compact('portfolio'));
        } else {
            abort(404, 'Portfolio not found.');
        }
    }

    public function showDesignerProfile($id)
    {
        // Fetch the designer with their portfolio
        $designer = User::with('portfolio')->findOrFail($id);
    
        // Parse the specialization data into an array
        if ($designer->portfolio) {
            $designer->portfolio->specialization = explode(',', $designer->portfolio->specialization);
        }
    
        return view('designers.profile', compact('designer'));
    }

    public function startConversation(Request $request, $recipientId)
    {
        $user = Auth::user();
        $recipient = User::findOrFail($recipientId);

        // Check if a conversation already exists between the users
        $conversation = $user->getConversationWith($recipient);

        // If a conversation does not exist, start a new one
        if (!$conversation) {
            $conversation = $user->startConversationWith($recipient);
        }

        // Redirect to the conversation view
        return redirect()->route('conversations.show', ['conversationId' => $conversation->id])->with('success', 'Conversation started successfully!');
    }



}
