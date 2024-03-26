<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\PortfolioItem;

class PortfolioController extends Controller
{
    public function index()
    {
        // Get all portfolios of DESIGNER users
        $portfolios = User::where('role', 'DESIGNER')->with('portfolio')->get();

        return view('portfolios.index', compact('portfolios'));
    }

    public function show(User $user)
    {

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a DESIGNER
        if ($user->role !== 'DESIGNER') {
            abort(403, 'Unauthorized action.');
        }
    
        // Get the portfolio of the DESIGNER
        $portfolio = $user->portfolio;
    
        // Check if the portfolio exists
        if ($portfolio) {
            // Load the items associated with the portfolio
            $portfolio->load('items');
    
            // Pass the portfolio data to the view
            return view('portfolios.show', compact('portfolio'));
        } else {
            abort(404, 'Portfolio not found.');
        }
    }
    




    public function modify(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is a DESIGNER
        if ($user->role !== 'DESIGNER') {
            // Redirect or show error message if the user is not a DESIGNER
        }

        // Get or create the portfolio of the DESIGNER
        $portfolio = Portfolio::firstOrNew(['user_id' => $user->id]);

        // Return the modify view with the portfolio data
        return view('portfolios.modify', compact('portfolio'));
    }

    public function storeOrUpdate(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size and allowed mime types as needed
        'text_description_content' => 'nullable|string',
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Get or create the portfolio of the DESIGNER
    $portfolio = Portfolio::firstOrNew(['user_id' => $user->id]);

    // Save or update the portfolio details
    $portfolio->title = $request->input('title');
    $portfolio->description = $request->input('description');
    $portfolio->save();

    // Upload and store image for the portfolio
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $image->store('portfolio_images', 'public');
        $portfolio->items()->create(['type' => 'image', 'content' => $imagePath]);
    }

    // Add text description for the portfolio
    if ($request->filled('text_description_content')) {
        $textDescription = $request->input('text_description_content');
        $portfolio->items()->create(['type' => 'text', 'content' => $textDescription]);
    }

    // Redirect back with success message
    return redirect()->route('portfolios.modify')->with('success', 'Portfolio updated successfully!');
}



}

