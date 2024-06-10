<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedules;

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

    public function create()
    {
        return view('appointments.create');
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
