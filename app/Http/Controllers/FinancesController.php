<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialData;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects; // Correct reference if your model is named Project

class FinancesController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Assuming you want to fetch projects related to the logged-in user
        // Assuming you want to show all financial data, adjust the query as needed
        $financialDatas = FinancialData::whereHas('project', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
        
        // Pass the financialDatas variable to the view
        return view('finances.index', compact('financialDatas'));
    }


    protected function prepareChartData($financialData)
    {
        $labels = $financialData->pluck('date')->unique();
        $dataset = $financialData->groupBy('date')->map(function ($items) {
            return $items->sum('amount');
        });

        return [
            'labels' => $labels->all(),
            'datasets' => [
                [
                    'label' => 'Financial Activity',
                    'data' => $dataset->values()->all(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    public function edit($id)
    {
        $finance = FinancialData::findOrFail($id); // Assuming Finance is your model name
        $projects = Projects::where('user_id', Auth::id())->pluck('title', 'id');

        return view('finances.edit', compact('finance', 'projects'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'cost_estimation' => 'required|numeric',
            'actual_cost' => 'required|numeric',
            'tax' => 'required|numeric',
            'additional_fees' => 'required|numeric',
        ]);

        $financialData = FinancialData::findOrFail($id);
        $financialData->update($request->all());

        // Redirect to a relevant page with a success message
        return redirect()->route('some.route')->with('success', 'Financial data updated successfully!');
    }

    public function create()
    {
        $projects = Projects::where('user_id', Auth::id())->pluck('title', 'id');

        if ($projects->isEmpty()) {
            return back()->with('error', 'No projects found.');
        }

        return view('finances.create', compact('projects'));
    }


    public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required|integer|exists:projects,id',
        'cost_estimation' => 'required|numeric',
        'actual_cost' => 'required|numeric',
        'tax' => 'required|numeric',
        'additional_fees' => 'required|numeric',
    ]);

    FinancialData::create([
        'project_id' => $request->input('project_id'),
        'cost_estimation' => $request->input('cost_estimation', 0), // Providing a default value as an example
        'actual_cost' => $request->input('actual_cost', 0),
        'tax' => $request->input('tax', 0),
        'additional_fees' => $request->input('additional_fees', 0),
    ]);
    

    // Redirect back or to another page after successful creation
    return redirect()->route('finances.index')->with('success', 'Financial data added successfully.');
}
    public function show($projectId)
    {
        // Retrieve financial data for the project
        $finance = FinancialData::where('project_id', $projectId)->firstOrFail();

        // Retrieve project details
        $project = Projects::findOrFail($projectId);

        // Pass the data to the view
        return view('finances.show', compact('finance', 'project'));
    }

    




}
