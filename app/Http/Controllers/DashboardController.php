<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Import the correct Request class
use App\Models\Projects; // Assuming Project model exists
use App\Models\User;

class DashboardController extends Controller{

    public function index()
    {
        $user = Auth::user();
        $userRole = $user->role; // Assuming 'role' is the column in your users table that stores user role
        // dd($userRole); // Check if $userRole is correctly retrieved
        return view('dashboard', ['userRole' => $userRole]);
    }

    public function search(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('query');

        // Perform the search using the Project model
        $results = Projects::where('title', 'like', "%$query%")
                          ->orWhere('description', 'like', "%$query%")
                          ->get();

        // Pass the search results to the view
        return view('search-results', ['results' => $results]);
    }

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
