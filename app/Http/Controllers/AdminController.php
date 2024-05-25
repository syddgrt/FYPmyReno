<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\User;
use App\Models\FinancialData;
use App\Models\Collaborations;

class AdminController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'You do not have admin access.']);
            }
        }

        // Authentication failed
        return redirect()->route('admin.login')->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    

    public function dashboard()
    {
        
        return view('admin.dashboard');
    }


    public function collaborations()
    {
        $collaborations = Collaborations::with(['client', 'designer', 'project'])->get(); // Eager load client and designer relationships

        return view('admin.collaborations', ['collaborations' => $collaborations]);
    }

    public function destroyCollaboration($id)
    {
        $collaboration = Collaborations::findOrFail($id);
        $collaboration->delete();

        return redirect()->route('admin.collaborations')->with('success', 'Collaboration deleted successfully.');
    }

    public function finances()
    {
        $finances = FinancialData::all(); // Retrieve all finance records from the database

        return view('admin.finances', ['finances' => $finances]);
    }

    public function destroyFinancialData($id)
    {
        $finances = FinancialData::findOrFail($id);
        $finances->delete();

        return redirect()->route('admin.finances')->with('success', 'Financial Data deleted successfully.');
    }

    public function messages()
    {
        return view('admin.messages');
    }

    public function projects()
    {
        // Eager load the 'client' and 'designer' relationships
        $projects = Projects::with(['client', 'designer'])->get();

        return view('admin.projects', ['projects' => $projects]);
    }

    public function destroyProjects($id)
    {
        $project = Projects::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Project deleted successfully.');
    }

    public function users()
    {
        $users = User::all(); // Retrieve all users from the database

        return view('admin.users', ['users' => $users]);
    }
}
