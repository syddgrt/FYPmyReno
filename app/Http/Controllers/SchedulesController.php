<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedules;
use App\Models\Projects;
use App\Models\User;

class SchedulesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'collaboration_id' => 'required|exists:collaborations,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'place' => 'required|string',
        ]);

        Schedules::create($request->all());

        return redirect()->route('collaborations.index')->with('success', 'Schedule created successfully!');
    }

    public function update(Request $request, Schedules $appointment)
    {

        $appointment->update($request->all());

        return redirect()->back()->with('success', 'Appointment updated successfully!');
    }

    public function create(Request $request)
    {
        // Retrieve project and client information using the project_id and client_id from the request
        $project = Projects::findOrFail($request->input('project_id'));

        // Assuming the project has a 'user_id' field that links to the client
        $client = User::findOrFail($project->user_id);

        return view('appointments.create', compact('project', 'client'));
    }

    public function show($id)
    {
        $appointment = Schedules::findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Schedules::findOrFail($id);
        return view('appointments.edit', compact('appointment'));
    }

    public function destroy(Schedules $appointment)
    {
        $appointment->delete();

        return redirect()->route('collaborations.index')->with('success', 'Appointment deleted successfully!');
    }
    
}
