<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialData;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects; // Correct reference if your model is named Project
use App\Models\Collaborations;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;




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

        // Calculate sums of financial data
        $totalCostEstimation = $financialDatas->sum('cost_estimation');
        $totalActualCost = $financialDatas->sum('actual_cost');
        $totalTax = $financialDatas->sum('tax');
        $totalAdditionalFees = $financialDatas->sum('additional_fees');
        
        return view('finances.index', compact('financialDatas', 'totalCostEstimation', 'totalActualCost', 'totalTax', 'totalAdditionalFees'));
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


    public function create()
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $role = Auth::user()->role; // Get the role of the logged-in user

        // Query to fetch projects where the designer has collaborations
        $projectsQuery = Projects::whereHas('collaborations', function ($query) use ($userId) {
            $query->where('designer_id', $userId)->where('status', 'accepted');
        });

        // Filter projects based on user role and existing financial data
        $projects = $projectsQuery->whereNotExists(function ($query) use ($userId) {
            $query->select('id')
                ->from('financial_datas')
                ->whereRaw('financial_datas.project_id = projects.id')
                ->where('user_id', $userId);
        })->pluck('title', 'id');

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

    public function downloadPdf($projectId)
    {
        return $this->generatePdf($projectId);
    }

    public function generatePdf($projectId)
{
    Log::info('generatePdf called with projectId: ' . $projectId);

    try {
        // Retrieve financial data for the project
        $finance = FinancialData::where('project_id', $projectId)->firstOrFail();
        Log::info('Financial data retrieved: ' . json_encode($finance));

        // Retrieve project details
        $project = Projects::findOrFail($projectId);
        Log::info('Project details retrieved: ' . json_encode($project));

        // Pass the fetched data to the Blade view
        $data = [
            'finance' => $finance,
            'project' => $project,
        ];
        Log::info('Data prepared for PDF: ' . json_encode($data));

        // Define the directory and file name for the PDF
        $directory = public_path('pdfs');
        $filePath = $directory . '/finance.pdf';
        Log::info('PDF will be saved to: ' . $filePath);

        // Ensure the directory exists
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
            Log::info('Directory created: ' . $directory);
        } else {
            Log::info('Directory already exists: ' . $directory);
        }

        // Set the path to the Node.js executable
        $nodeBinary = 'C:\Program Files\nodejs\node.exe'; // Modify this path if necessary

        // Generate PDF using Browsershot with the specified Node.js binary path
        Log::info('Starting PDF generation...');
        Browsershot::html('<h1>Hello world</h1>')
            ->setNodeBinary($nodeBinary)
            ->save($filePath);
        Log::info('PDF generated successfully at: ' . $filePath);

        // Return a response to download the generated PDF file
        Log::info('Preparing response for file download...');
        return response()->download($filePath);

    } catch (\Exception $e) {
        Log::error('PDF generation failed: ' . $e->getMessage());
        return back()->with('error', 'PDF generation failed: ' . $e->getMessage());
    }
}

    



    public function destroy($id)
    {
        $finance = FinancialData::findOrFail($id);
        $finance->delete();

        return redirect()->route('finances.index')->with('success', 'Financial data deleted successfully.');
    }
        




}
