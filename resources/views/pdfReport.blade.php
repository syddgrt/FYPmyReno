<!DOCTYPE html>
<html>
<head>
    <title>Financial Data Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #343a40;
        }
        .subtitle {
            font-size: 22px;
            color: #6c757d;
        }
        .section {
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #e9ecef;
            color: #343a40;
            font-weight: bold;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-amount {
            color: #dc3545;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            flex: 1;
            text-align: center;
        }
        .signature h4 {
            margin-bottom: 10px;
            color: #343a40;
        }
        .signature-line {
            border-bottom: 2px solid #343a40;
            width: 150px;
            margin: 0 auto 20px;
        }
        .chart-container {
            margin-top: 40px;
            text-align: center;
        }
        .chart {
            margin-bottom: 30px;
        }
        .chart img {
            max-width: 100%;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">Financial Data Report</div>
            <div class="subtitle">{{ $project->title }}</div>
        </div>

        <div class="section">
            <div class="section-title">Proposed Cost</div>
            <table class="table">
                <tr>
                    <th>Description</th>
                    <th>Amount (RM)</th>
                </tr>
                <tr>
                    <td>Proposed Cost</td>
                    <td>{{ number_format($finance->cost_estimation, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Financial Details</div>
            <table class="table">
                <tr>
                    <th>Category</th>
                    <th>Amount (RM)</th>
                </tr>
                <tr>
                    <td>Actual Cost</td>
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
                <tr class="total-row">
                    <td>Total Cost</td>
                    <td class="total-amount">{{ number_format($totalCost, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Signatures</div>
            <div class="signature-section">
                <div class="signature">
                    <h4>Client Signature</h4>
                    <div class="signature-line"></div>
                </div>
                <div class="signature">
                    <h4>Designer Signature</h4>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            @if(isset($analyticsChart))
                <div class="chart">
                    <h3>Analytics Chart</h3>
                    <img src="{{ $analyticsChart }}" alt="Analytics Chart">
                </div>
            @endif
            @if(isset($pieChart))
                <div class="chart">
                    <h3>Pie Chart</h3>
                    <img src="{{ $pieChart }}" alt="Pie Chart">
                </div>
            @endif
        </div>

        <div class="footer">
            <p>Generated by MyReno</p>
            <p><strong>Note:</strong> This is not a payment invoice!</p>
        </div>
    </div>
</body>
</html>

