<?php

namespace App\Http\Controllers;

use Closure;
use App\Http\Controllers\Controller; // Import the base controller class
use App\Models\Projects;
use App\Models\ProjectAttachment;
use App\Models\User;
use App\Http\Requests\StoreProjectsRequest;
use App\Http\Requests\UpdateProjectsRequest;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Storage; // Import the Storage facade
use App\Models\Collaborations;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Initialize an empty collection
        $projects = collect();

        // Show all projects to DESIGNERS
        if ($user->role === 'DESIGNER') {
            $projects = Projects::all();
        }
        // Show only client's projects to CLIENTS
        else {
            if ($user->projects()->exists()) {
                $projects = $user->projects;
            }
        }

        return view('projects.index', compact('projects'));
    }

    public function clientProjects()
    {
        $user = auth()->user();
        $projects = $user->projects; // Show only client's projects to CLIENTS
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectsRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // Adjust the max file size as needed
        ]);

        // Create a new project instance
        $project = new Projects();
        $project->user_id = Auth::id();
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->save(); // Save the project first

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPath = $file->store('attachments');
                $attachment = new ProjectAttachment();
                $attachment->project_id = $project->id; // Use the project's id after it has been saved
                $attachment->file_path = $attachmentPath;
                $attachment->type = 'default'; // Set a default value for the type
                $attachment->save();
            }
        }

        // Redirect the user to a relevant page
        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Projects $project)
    {
        // Load the user relationship to access the creator's email
        $project->load('user');

        // Retrieve attachments associated with the project
        $attachments = $project->attachments;

        // Map attachment paths
        $images = $attachments->pluck('file_path')->toArray();

        // Retrieve collaboration requests for the project
        $collaborationRequests = Collaborations::where('project_id', $project->id)->get();

        return view('projects.show', compact('project', 'images', 'collaborationRequests'));
    }


    /**
     * Show the form for editing the specified resource.
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

    



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectsRequest $request, Projects $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $projects)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // Adjust the max file size as needed
        ]);

        // Update the project
        $projects->title = $request->input('title');
        $projects->description = $request->input('description');
        $projects->save();

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPath = $file->store('attachments');
                $attachment = new Attachment();
                $attachment->project_id = $projects->id; // Associate attachment with project
                $attachment->file_path = $attachmentPath;
                $attachment->save();
            }
        }

        // Redirect the user to a relevant page
        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }
    
}



