<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\FinancialData;
use App\Models\Projects;
use App\Models\User;
use App\Models\Collaborations;

class PDFController extends Controller
{
    public function generatePDF(Request $request, $projectId)
    {
        // Retrieve chart images from the request
        $analyticsChart = $request->input('analyticsChart');
        $pieChart = $request->input('pieChart');

        // Retrieve financial data for the project
        $finance = FinancialData::where('project_id', $projectId)->firstOrFail();

        // Retrieve project details
        $project = Projects::findOrFail($projectId);

        // Retrieve client and designer names
        $clientName = User::findOrFail($project->user_id)->name;

        // Fetch the designer ID from the collaboration table
        $collaboration = Collaborations::where('project_id', $projectId)->firstOrFail();
        $designerId = $collaboration->designer_id;
        $designerName = User::findOrFail($designerId)->name;

        // Calculate total cost
        $totalCost = $finance->actual_cost + $finance->tax + $finance->additional_fees;

        // Convert image to base64
        $path = public_path('image/MyRenoLogo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Pass the data to the PDF view
        $data = [
            'finance' => $finance,
            'project' => $project,
            'totalCost' => $totalCost,
            'clientName' => $clientName,
            'designerName' => $designerName,
            'base64' => $base64,
            'analyticsChart' => $analyticsChart,
            'pieChart' => $pieChart
        ];

        // Load the PDF view and generate the PDF
        $pdf = PDF::loadView('pdfReport', $data);

        // Return the PDF as a response
        return $pdf->stream('pdfReport.pdf');
    }
}
