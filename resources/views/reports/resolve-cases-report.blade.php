<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolved Cases Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
            padding: 15px;
            margin-left: 20px;
            margin-right: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1a4b84;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1a4b84;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
            font-weight: 600;
            color: #000;
        }
        .filters {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 500;
        }
        .filters p {
            margin: 3px 0;
            color: #000;
        }
        .filters strong {
            color: #1a4b84;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead {
            background-color: #1a4b84;
            color: white;
        }
        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid #0d3a5f;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 12px;
            font-weight: normal;
            color: #000;
            vertical-align: top;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            font-weight: normal;
            color: #000;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #000;
            font-size: 13px;
            font-weight: 500;
            font-style: italic;
        }
        
        @media print {
            body {
                margin-left: 20px !important;
                margin-right: 20px !important;
                color: #000 !important;
            }
            td {
                font-weight: normal !important;
                color: #000 !important;
            }
            th {
                font-weight: 700 !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Resolved Cases Report</h1>
        <p>Immaculate Conception School of Naic Inc. - Guidance Office</p>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
    </div>

    @if (!empty($filters['search']))
    <div class="filters">
        <p><strong>Filters Applied:</strong></p>
        <p>Search: <strong>{{ $filters['search'] }}</strong></p>
    </div>
    @endif

    @if ($requests->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No.</th>
                    <th style="width: 18%;">Student</th>
                    <th style="width: 12%;">Grade & Section</th>
                    <th style="width: 12%;">Contact</th>
                    <th style="width: 12%;">Preferred Support</th>
                    <th style="width: 12%;">Urgency</th>
                    <th style="width: 20%;">Remarks</th>
                    <th style="width: 10%;">Completed Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $index => $request)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $request->fullname ?? 'Anonymous Student' }}</td>
                        <td>{{ $request->grade_section ?? '—' }}</td>
                        <td>{{ $request->contact_details ?? '—' }}</td>
                        <td>{{ $request->support_method ? ucfirst($request->support_method) : 'No preference' }}</td>
                        <td>{{ $request->urgent_level ?? '—' }}</td>
                        <td>{{ $request->remarks ?? 'No remarks provided' }}</td>
                        <td>{{ optional($request->updated_at)->format('M d, Y • h:i A') ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No resolved cases found matching the selected filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>Total Records: {{ $requests->count() }}</p>
        <p>This is a computer-generated report.</p>
    </div>
</body>
</html>

