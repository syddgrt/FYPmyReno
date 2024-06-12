<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Collaborations;
use App\Models\FinancialData;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use PDF;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showPaymentPage(Projects $project)
    {
        $collaboration = Collaborations::where('project_id', $project->id)->first();
        $finance = FinancialData::where('project_id', $project->id)->first();

        return view('payment', compact('project', 'collaboration', 'finance'));
    }

    public function processPayment(Request $request, Projects $project)
    {
        Log::info('Payment process started for project ID: ' . $project->id);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            Log::info('Creating Stripe customer');
            // Create a new Stripe customer if necessary
            $customer = Customer::create([
                'email' => auth()->user()->email,
                'source' => $request->stripeToken,
            ]);

            Log::info('Customer created: ' . $customer->id);

            $finance = FinancialData::where('project_id', $project->id)->first();
            Log::info('Finance data retrieved: ' . json_encode($finance));

            $collaboration = Collaborations::where('project_id', $project->id)->first(); // Add this line

            $totalCost = $finance->actual_cost + $finance->tax + $finance->additional_fees;
            $amount = $totalCost * 100;

            Log::info('Creating Stripe charge for amount: ' . $amount);

            // Create a charge
            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $amount,
                'currency' => 'myr',
                'description' => 'Payment for project ' . $project->title,
            ]);

            Log::info('Charge created: ' . $charge->id);

            // Store payment details in session
            session()->put('payment_details', [
                'project' => $project,
                'collaboration' => $collaboration,
                'finance' => $finance,
                'charge' => $charge,
            ]);

            return redirect()->route('payment.success')->with('success', 'Payment Submitted Successfully!');
        } catch (\Exception $e) {
            Log::error('Payment failed: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Payment failed: ' . $e->getMessage()]);
        }
    }

    public function paymentSuccess()
    {
        // Retrieve payment details from session
        $paymentDetails = session()->get('payment_details');

        return view('payment_success', $paymentDetails)->with('success', 'Payment submitted successfully!');
    }

    public function downloadInvoice()
    {
        // Retrieve payment details from session
        $paymentDetails = session()->get('payment_details');

    
        // Generate the invoice PDF
        $pdf = PDF::loadView('invoice', $paymentDetails);

        return $pdf->download('myReno-Invoice.pdf');
    }
}

