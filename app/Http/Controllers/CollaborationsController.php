<?php

namespace App\Http\Controllers;

use App\Models\Collaborations;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaborationsController extends Controller
{
    /**
     * Store a newly created collaboration request in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            // Add validation rules for the request data
        ]);

        // Retrieve the project
        $project = Projects::findOrFail($request->input('project_id'));

        // Create a new collaboration request
        Collaborations::create([
            'designer_id' => Auth::id(), // Assign the current designer's ID
            'client_id' => $project->user_id, // Use the user_id of the project owner as client_id
            'project_id' => $request->input('project_id'),
            'status' => 'pending', // Assuming the default status is 'pending'
        ]);

        // Redirect the user to a relevant page
        return redirect()->back()->with('success', 'Collaboration request sent successfully!');
    }



    /**
     * Update the specified collaboration request in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collaborations  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collaborations $collaboration)
    {
        $request->validate([
            'status' => 'required|in:accepted,denied',
        ]);

        $collaboration->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Collaboration request updated successfully!');
    }

    public function index()
    {
        // Retrieve collaboration requests for the logged-in client
        $collaborationRequests = Collaborations::where('client_id', Auth::id())->get();

        // Load designer details for each collaboration request
        $collaborationRequests->load('designer');

        return view('collaborations.index', compact('collaborationRequests'));
    }

    /**
     * Remove the specified collaboration request from storage.
     *
     * @param  \App\Models\Collaborations  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collaborations $collaboration)
    {
        // Delete the collaboration request
        $collaboration->delete();

        // Redirect the user to a relevant page
        return redirect()->back()->with('success', 'Collaboration request deleted successfully!');
    }

    
}
