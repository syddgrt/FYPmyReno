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
            'place' => 'required|string', // Add validation for place
        ]);

        Schedules::create($request->all());

        return redirect()->back()->with('success', 'Schedule created successfully!');
    }

    public function update(Request $request, Schedules $schedule)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'place' => 'required|string', // Add validation for place
        ]);

        $schedule->update($request->all());

        return redirect()->back()->with('success', 'Schedule updated successfully!');
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



    
}
