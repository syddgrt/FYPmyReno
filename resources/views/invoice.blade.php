<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>myReno Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            
        }
        .header img {
            max-width: 150px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            margin: 0;
        }
        .invoice-details,
        .invoice-summary {
            margin-bottom: 20px;
        }
        .invoice-details table,
        .invoice-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th,
        .invoice-details td,
        .invoice-summary th,
        .invoice-summary td {
            border: 1px solid #000;
            padding: 10px;
        }
        .invoice-summary {
            text-align: right;
        }
        .invoice-summary table {
            width: auto;
            margin-left: auto;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
        .total h2 {
            margin: 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <div class="myReno">myReno</div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>Invoice Date: {{ date('d M Y') }}</p>
                <p>Invoice No: 5</p>
            </div>
        </div>
       
        <div class="invoice-details">
            <table>
                <tr>
                    <th>Description</th>
                    <th>Amount (RM)</th>
                </tr>
                <tr>
                    <td>Project Name</td>
                    <td>{{ $project->title }}</td>
                </tr>
                <tr>
                    <td>Project Description</td>
                    <td>{{ $project->description }}</td>
                </tr>
                @if($collaboration)
                <tr>
                    <td>Designer Email</td>
                    <td>{{ $collaboration->designer->email }}</td>
                </tr>
                @endif
                <tr>
                    <td>Proposed Cost</td>
                    <td>RM{{ number_format($finance->cost_estimation, 2) }}</td>
                </tr>
                <tr>
                    <td>Actual Cost</td>
                    <td>RM{{ number_format($finance->actual_cost, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>RM{{ number_format($finance->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Additional Fees</td>
                    <td>RM{{ number_format($finance->additional_fees, 2) }}</td>
                </tr>
            </table>
        </div>
        <div class="invoice-summary">
            <table>
                <tr>
                    <td>Total Exclusive Tax</td>
                    <td>RM{{ number_format($finance->actual_cost, 2) }}</td>
                </tr>
                <tr>
                    <td>Service Tax @ 6%</td>
                    <td>RM{{ number_format($finance->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Total Inclusive Tax</td>
                    <td>RM{{ number_format($finance->actual_cost + $finance->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Additional Fees</td>
                    <td>RM{{ number_format($finance->additional_fees, 2) }}</td>
                </tr>
                <tr>
                    <th>Total Amount Payable</th>
                    <th>RM{{ number_format($finance->actual_cost + $finance->tax + $finance->additional_fees, 2) }}</th>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Thank you for doing business with myReno!</p>
            <p>This invoice is computer generated and requires no authorized signature.</p>
        </div>
    </div>
</body>
</html>
