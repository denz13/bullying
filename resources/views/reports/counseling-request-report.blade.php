<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counseling Request Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
            margin-left: 40px;
            margin-right: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1a4b84;
        }
        .header h1 {
            font-size: 18pt;
            color: #1a4b84;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 9pt;
            color: #666;
        }
        .filters {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            font-size: 9pt;
        }
        .filters p {
            margin: 3px 0;
        }
        .filters strong {
            color: #1a4b84;
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
            padding: 8px 6px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            border: 1px solid #0d3a5f;
        }
        td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 9pt;
            vertical-align: top;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: capitalize;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8pt;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Counseling Request Report</h1>
        <p>Immaculate Conception School of Naic Inc. - Guidance Office</p>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
    </div>

    @if (!empty($filters['status']) || !empty($filters['search']))
    <div class="filters">
        <p><strong>Filters Applied:</strong></p>
        @if (!empty($filters['status']))
            <p>Status: <strong>{{ ucfirst($filters['status']) }}</strong></p>
        @endif
        @if (!empty($filters['search']))
            <p>Search: <strong>{{ $filters['search'] }}</strong></p>
        @endif
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
                    <th style="width: 10%;">Status</th>
                    <th style="width: 12%;">Submitted</th>
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
                        <td>
                            <span class="badge badge-{{ strtolower($request->status ?? 'pending') }}">
                                {{ ucfirst($request->status ?? 'pending') }}
                            </span>
                        </td>
                        <td>{{ optional($request->created_at)->format('M d, Y • h:i A') ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No counseling requests found matching the selected filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>Total Records: {{ $requests->count() }}</p>
        <p>This is a computer-generated report.</p>
    </div>
</body>
</html>

