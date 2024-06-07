<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialData;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects; // Correct reference if your model is named Project
use App\Models\Collaborations;
use App\Models\User; // Correct reference if your model is named Project

class FinancesController extends Controller
{
    public function index(Request $request)
{
    $userId = Auth::id(); // Get the logged-in user's ID

    // Get the client_id from the request if it exists
    $clientId = $request->query('client_id');

    // Retrieve financial data filtered by projects the designer is collaborating on or created
    $financialDatas = FinancialData::whereHas('project', function ($query) use ($userId, $clientId) {
        $query->where(function ($q) use ($userId, $clientId) {
            $q->where('user_id', $userId); // Filter by projects created by the current user
            if ($clientId) {
                $q->where('user_id', $clientId); // Filter by selected client
            }
            $q->orWhereHas('collaborations', function ($query) use ($userId, $clientId) {
                $query->where('designer_id', $userId)->where('status', 'accepted'); // Filter by projects the current user is collaborating on
                if ($clientId) {
                    $query->whereHas('project', function ($q) use ($clientId) {
                        $q->where('user_id', $clientId); // Filter by selected client
                    });
                }
            });
        });
    })->get();

    // Calculate sums of financial data
    $totalCostEstimation = $financialDatas->sum('cost_estimation');
    $totalActualCost = $financialDatas->sum('actual_cost');
    $totalTax = $financialDatas->sum('tax');
    $totalAdditionalFees = $financialDatas->sum('additional_fees');

    // Get the list of clients the designer is collaborating with
    $clients = User::whereHas('projects', function ($query) use ($userId) {
        $query->whereHas('collaborations', function ($query) use ($userId) {
            $query->where('designer_id', $userId)->where('status', 'accepted');
        });
    })->get();

    return view('finances.index', compact('financialDatas', 'totalCostEstimation', 'totalActualCost', 'totalTax', 'totalAdditionalFees', 'clients', 'clientId'));
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
        $projects = Projects::findOrFail($finance->project_id); // Retrieve the specific project

        return view('finances.edit', compact('finance', 'projects'));
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Base validation rules
        $rules = [
            'cost_estimation' => 'required|numeric',
        ];

        // Additional rules for designers
        if ($user->role === 'DESIGNER') {
            $rules['actual_cost'] = 'required|numeric';
            $rules['tax'] = 'required|numeric';
            $rules['additional_fees'] = 'required|numeric';
        }

        $request->validate($rules);

        $financialData = FinancialData::findOrFail($id);

        // Update only cost_estimation for clients
        if ($user->role === 'CLIENT') {
            $financialData->update([
                'cost_estimation' => $request->input('cost_estimation'),
            ]);
        } else {
            // Update all fields for designers
            $financialData->update($request->all());
        }

        // Redirect to the finances index page with a success message
        return redirect()->route('finances.index')->with('success', 'Financial data updated successfully!');
    }


    public function create(Request $request)
{
    $userId = Auth::id(); // Get the logged-in user's ID
    $role = Auth::user()->role; // Get the role of the logged-in user

    // Get the list of clients the designer is collaborating with
    $clients = User::whereHas('projects', function ($query) use ($userId) {
        $query->whereHas('collaborations', function ($query) use ($userId) {
            $query->where('designer_id', $userId)->where('status', 'accepted');
        });
    })->get();

    $clientId = $request->query('client_id');

    // Query to fetch projects where the designer has collaborations and based on selected client
    $projectsQuery = Projects::whereHas('collaborations', function ($query) use ($userId) {
        $query->where('designer_id', $userId)->where('status', 'accepted');
    });

    // Filter projects based on selected client
    if ($clientId) {
        $projectsQuery->where('user_id', $clientId);
    }

    // Filter projects based on existing financial data
    $projects = $projectsQuery->whereNotExists(function ($query) use ($userId) {
        $query->select('id')
            ->from('financial_datas')
            ->whereRaw('financial_datas.project_id = projects.id')
            ->where('user_id', $userId);
    })->pluck('title', 'id');

    return view('finances.create', compact('projects', 'clients', 'clientId'));
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
        $totalCost = $finance->actual_cost + $finance->tax + $finance->additional_fees;

        // Pass the data to the view
        return view('finances.show', compact('finance', 'project', 'totalCost'));
    }

    public function destroy($id)
    {
        $finance = FinancialData::findOrFail($id);
        $finance->delete();

        return redirect()->route('finances.index')->with('success', 'Financial data deleted successfully.');
    }





}
