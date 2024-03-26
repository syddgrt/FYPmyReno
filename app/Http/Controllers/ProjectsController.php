<?php

namespace App\Http\Controllers;

use Closure;
use App\Http\Controllers\Controller; // Import the base controller class
use App\Models\Projects;
use App\Http\Requests\StoreProjectsRequest;
use App\Http\Requests\UpdateProjectsRequest;
use Illuminate\Support\Facades\Auth; // Import Auth facade


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Show all projects to DESIGNERS
        if ($user->role === 'DESIGNER') {
            $projects = Projects::all();
        }
        // Show only client's projects to CLIENTS
        else {
            $projects = $user->projects;
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
            'attachment' => 'nullable|file|max:10240', // Adjust the max file size as needed
        ]);

        // Create a new project instance
        $project = new Projects();
        $project->user_id = Auth::id();
        $project->title = $request->input('title');
        $project->description = $request->input('description');

        // Handle attachment
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments');
            $project->attachment = $attachmentPath;
        }

        // Save the project
        $project->save();

        // Redirect the user to a relevant page
        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Projects $projects)
    {
        $images = json_decode($projects->attachment, true);
    
        // Pass the $projects and $images variables to the view
        return view('projects.show', compact('projects', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $projects)
    {
        //
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
        //
    }
}



