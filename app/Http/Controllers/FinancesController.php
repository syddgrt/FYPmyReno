<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialData;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects; // Correct reference if your model is named Project
use App\Models\Collaborations;

class FinancesController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $financialDatas = FinancialData::whereHas('project', function ($query) use ($userId) {
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId) // Filter by projects created by the current user
                  ->orWhereHas('collaborations', function ($query) use ($userId) {
                      $query->where('designer_id', $userId)->where('status', 'accepted'); // Filter by projects the current user is collaborating on
                  });
            });
        })->get();

        $financialDatas = FinancialData::all();
        
        // Calculate sums of financial data
        $totalCostEstimation = $financialDatas->sum('cost_estimation');
        $totalActualCost = $financialDatas->sum('actual_cost');
        $totalTax = $financialDatas->sum('tax');
        $totalAdditionalFees = $financialDatas->sum('additional_fees');
        
        return view('finances.index', compact('financialDatas','totalCostEstimation', 'totalActualCost', 'totalTax', 'totalAdditionalFees'));
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
        // Retrieve projects for selection
        $projects = Projects::pluck('title', 'id');

        return view('finances.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'cost_estimation' => 'required|numeric',
            'actual_cost' => 'required|numeric',
            'tax' => 'required|numeric',
            'additional_fees' => 'required|numeric',
        ]);

        FinancialData::create($request->all());

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
