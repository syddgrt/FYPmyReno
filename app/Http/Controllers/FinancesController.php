<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialData; // Assuming FinancialData model exists

class FinancesController extends Controller
{
    /**
     * Display the finances information and basic data analytics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve financial data from the database
        $financialData = FinancialData::all(); // Adjust this based on your model and database structure

        // Sample data for the analytics chart
        $chartData = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [5000, 5500, 6000, 6500, 7000, 7500],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];

        return view('finances.index', compact('financialData', 'chartData'));
    }
}
