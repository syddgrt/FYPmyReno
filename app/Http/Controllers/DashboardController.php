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

    $activeCollaborations = [];
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

        // Debugging output
        logger()->info('Client active collaborations:', $activeCollaborations->toArray());
    } elseif ($userRole === 'DESIGNER') {
        // Fetch active collaborations for designers
        $activeCollaborations = Collaborations::where('designer_id', $user->id)
            ->where('status', 'accepted')
            ->with(['project' => function($query) {
                $query->with(['financialData', 'collaborations.projectSchedules']);
            }, 'projectSchedules']) // Load project schedules directly from collaborations
            ->get();

        // Debugging output
        logger()->info('Designer active collaborations:', $activeCollaborations->toArray());
    }

    return view('dashboard', [
        'userRole' => $userRole,
        'activeCollaborations' => $activeCollaborations
    ]);
}







    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $designers = User::where('role', 'DESIGNER')
                         ->when($search, function ($query, $search) {
                             return $query->where('name', 'like', '%' . $search . '%')
                                          ->orWhere('email', 'like', '%' . $search . '%');
                         })
                         ->get();

        return view('designers.index', compact('designers'));
    }

    // public function search(Request $request)
    // {
    //     // Get the search query from the request
    //     $query = $request->input('query');

    //     // Perform the search using the Project model
    //     $results = Projects::where('title', 'like', "%$query%")
    //                       ->orWhere('description', 'like', "%$query%")
    //                       ->get();

    //     // Pass the search results to the view
    //     return view('search-results', ['results' => $results]);
    // }

    public function showDesigners()
    {
        $designers = User::where('role', 'DESIGNER')->get();
        return view('designers.index', compact('designers'));
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
        $designer = User::findOrFail($id);

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
