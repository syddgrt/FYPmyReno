<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects; // Corrected model import
use App\Models\Collaborations; // Add this import
use App\Models\FinancialData; // Add this import

class PaymentController extends Controller
{
    public function showPaymentPage(Projects $project) // Corrected model type hint
    {
        // Retrieve the collaboration for this project
        $collaboration = Collaborations::where('project_id', $project->id)->first();

        // Retrieve the financial data for this project
        $finance = FinancialData::where('project_id', $project->id)->first();

        // Pass the project and collaboration to the view
        return view('payment', compact('project', 'collaboration', 'finance'));
    }

    public function processPayment(Request $request, Projects $project) // Corrected model type hint
    {
        $user = auth()->user();

        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($request->stripeToken);

        $amount = $project->finance->totalCost * 100; // Amount in cents

        $user->charge($amount, $request->stripeToken);

        return redirect()->route('finances.show', $project->id)->with('success', 'Payment successful!');
    }
}
