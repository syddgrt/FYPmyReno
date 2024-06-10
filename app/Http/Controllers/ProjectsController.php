<?php

namespace App\Http\Controllers;

use Closure;
use App\Http\Controllers\Controller; 
use App\Models\Projects;
use App\Models\ProjectAttachment;
use App\Models\User;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        
        $query = Projects::query();

        if ($user->role === 'CLIENT') {
            $query->where('user_id', $user->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $projects = $query->with('attachments')->get();

        return view('projects.index', [
            'projects' => $projects
        ]);
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
        'budget' => 'required|numeric|min:0',
        'attachments.*' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
    ]);

    // Create a new project instance
    $project = new Projects();
    $project->user_id = Auth::id();
    $project->title = $request->input('title');
    $project->description = $request->input('description');
    $project->budget = $request->input('budget');
    $project->save(); // Save the project first

    // Handle attachments
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $attachmentPath = $file->store('public/attachments');
            $attachmentPath = str_replace('public/', '', $attachmentPath);
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

        dd($project);
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
     * Update the specified resource in storage.
     */
    // ProjectsController.php

    public function edit($id)
    {
        $project = Projects::findOrFail($id);
        $userId = Auth::id();

        if ($project->user_id != $userId) {
            $isCollaborator = $project->collaborations()
                                    ->where('designer_id', $userId)
                                    ->where('status', 'accepted')
                                    ->exists();
            
            if (!$isCollaborator) {
                return redirect()->route('projects.index')->with('error', 'Unauthorized access to edit the project.');
            }
        }

        // Check if there are any active collaborations for this project
        $hasActiveCollaboration = $project->collaborations()
                                         ->where('status', 'accepted')
                                         ->exists();

        return view('projects.edit', compact('project', 'hasActiveCollaboration'));
    }

    // ProjectsController.php

    public function update(Request $request, Projects $project)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|in:Pending,In View,Finished',
    ]);

    $project->update($request->all());

    return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
}

    public function destroy(Projects $project)
    {
        // Check if the authenticated user is authorized to delete the project
        if (Auth::id() !== $project->user_id) {
            return redirect()->route('projects.index')->with('error', 'Unauthorized access to delete the project.');
        }

        // Delete project attachments
        foreach ($project->attachments as $attachment) {
            Storage::delete('public/' . $attachment->file_path);
            $attachment->delete();
        }

        // Delete the project
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }


    


    
}



