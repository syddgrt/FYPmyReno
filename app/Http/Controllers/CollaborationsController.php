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
        $request->validate([
            'project_id' => 'required|exists:projects,id|unique:collaborations,project_id,NULL,id,designer_id,'.Auth::id(),
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

    public function edit($id)
    {
        $project = Projects::findOrFail($id);
        $userId = Auth::id();

        // Check if the user is the project owner or has an accepted collaboration
        $isOwner = $project->user_id == $userId;
        $isCollaborator = $project->collaborations()
                                ->where('designer_id', $userId)
                                ->where('status', 'accepted')
                                ->exists();

        if (!$isOwner && !$isCollaborator) {
            return redirect()->route('projects.index')->with('error', 'Unauthorized access to edit the project.');
        }

        return view('projects.edit', compact('project'));
    }


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
        $userId = Auth::id();
        $user = Auth::user();
        $userRole = $user->role;

        if (Auth::user()->role === 'DESIGNER') {
            // Fetch collaborations where the authenticated user is the designer
            $collaborationRequests = Collaborations::where('designer_id', $userId)
                                                    ->with(['project', 'client']) // Assuming you have these relationships
                                                    ->get();
        } else {
            // Fetch collaborations related to the client's projects
            $collaborationRequests = Collaborations::whereHas('project', function ($query) use ($userId) {
                                                        $query->where('user_id', $userId);
                                                    })
                                                    ->with(['project', 'designer'])
                                                    ->get();
        }

        return view('collaborations.index', compact('collaborationRequests', 'userRole'));
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

    public function show(Projects $project)
    {
        $project->load('user');
        $attachments = $project->attachments;
        $images = $attachments->pluck('file_path')->toArray();
        $collaborationRequests = Collaborations::where('project_id', $project->id)->get();

        // Initialize $hasSentRequest as false for all users
        $hasSentRequest = false;
        $myRequest = null; // Initialize $myRequest

        // Update $hasSentRequest for DESIGNERS only and get the request if exists
        if (Auth::user()->role === 'DESIGNER') {
            $myRequest = Collaborations::where('project_id', $project->id)
                                    ->where('designer_id', Auth::id())
                                    ->first(); // Use first() to get the actual request if it exists
            $hasSentRequest = !is_null($myRequest); // Update based on existence of $myRequest
        }

        return view('projects.show', compact('project', 'images', 'collaborationRequests', 'hasSentRequest', 'myRequest'));
    }




    

    
}
