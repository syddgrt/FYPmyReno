<!DOCTYPE html>
<html>
<head>
    <title>PDF Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        h2 {
            color: #555;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        td {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>
    <h2><center>Invoice</center></h2>
    <h1>{{ $project->title }}</h1>

    <h3>Client: {{ $clientName }}</h3>
    <h3>Designer: {{ $designerName }}</h3>
    
    <table>
    <tr>
            <td>Proposed Cost</td>
            <td>{{ number_format($finance->cost_estimation, 2) }}</td>
        </tr>

        <tr>
            <th>Category</th>
            <th>Amount (RM)</th>
        </tr>
        
        <tr>
            <td>Estimation Cost</td>
            <td>{{ number_format($finance->actual_cost, 2) }}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td>{{ number_format($finance->tax, 2) }}</td>
        </tr>
        <tr>
            <td>Additional Fees</td>
            <td>{{ number_format($finance->additional_fees, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total Cost</strong></td>
            <td><strong>{{ number_format($totalCost, 2) }}</strong></td>
        </tr>
    </table>

     
</body>
</html>
