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

    public function show(string $id)
    {

    // Find the user by ID
    $user = User::findOrFail($id);

    // Log the user ID to see which user is being queried
    logger()->info('User ID: ' . $user->id);
    // dd($user->portfolio);
    // Get the portfolio of the DESIGNER
    $portfolio = $user->portfolio;
    
    // Log the portfolio data
    logger()->info('Portfolio Data: ' . json_encode($portfolio));
    

    // Check if the portfolio exists
        if ($portfolio) {
            // Load the items associated with the portfolio
            $portfolio->load('items');

            // Log the portfolio items
            logger()->info('Portfolio Items: ' . json_encode($portfolio->items));

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

    public function showDesignerProfile($designerId)
    {
        $designer = Designer::find($designerId);
        if (!$designer) {
            abort(404, 'Designer not found.');
        }

        $portfolio = $designer->portfolio; // Make sure this relationship exists in your Designer model

        return view('designers.profile', compact('designer', 'portfolio'));
    }

        // Add the deleteItem method to your PortfolioController
    public function deleteItem(PortfolioItem $item)
    {
        // Check if the authenticated user owns the portfolio item
        if ($item->portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the portfolio item
        $item->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Portfolio item deleted successfully!');
    }





}

