<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Projects;
use App\Models\Collaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function create($projectId)
    {
        $project = Projects::findOrFail($projectId);
        // Check if the project is finished
        if ($project->status !== 'Finished') {
            return redirect()->route('projects.show', $project)->with('error', 'Cannot leave a review unless the project is finished.');
        }

        // Get the accepted collaboration associated with the project
        $collaboration = $project->collaborations()->where('status', 'accepted')->first();
        $designer = $collaboration->designer;
        
        return view('reviews.create', compact('project', 'collaboration', 'designer'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'collaboration_id' => 'required|exists:collaborations,id',
            'designer_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'feedback' => 'nullable|string',
        ]);

        $project = Projects::findOrFail($request->input('project_id'));
        
        // Ensure the project is finished and the user is a client
        if ($project->status === 'Finished' && Auth::user()->id === $project->user_id) {
            Reviews::create([
                'project_id' => $request->input('project_id'),
                'collaboration_id' => $request->input('collaboration_id'),
                'designer_id' => $request->input('designer_id'),
                'client_id' => Auth::id(),
                'rating' => $request->input('rating'),
                'feedback' => $request->input('feedback'),
            ]);

            return redirect()->route('projects.show', $project)->with('success', 'Review submitted successfully!');
        }

        return redirect()->route('projects.show', $project)->with('error', 'Unauthorized to submit a review for this project.');
    }
}
