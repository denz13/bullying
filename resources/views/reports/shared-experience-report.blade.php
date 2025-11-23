<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Experience Report</title>
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
            padding: 15px;
            line-height: 1.3;
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 8px;
        }

        .header h1 {
            font-size: 16pt;
            color: #1f2937;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 8pt;
            color: #6b7280;
        }

        .filters {
            margin-bottom: 8px;
            padding: 6px 8px;
            background-color: #f5f5f5;
            border-radius: 3px;
            font-size: 8pt;
        }

        .filters h3 {
            font-size: 9pt;
            color: #1f2937;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }

        .filter-item strong {
            color: #4b5563;
            margin-right: 5px;
        }

        .filter-item span {
            color: #1f2937;
        }

        .no-filters {
            color: #6b7280;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            background-color: #fff;
        }

        thead {
            background-color: #4f46e5;
            color: #fff;
        }

        th {
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #3b3f9e;
        }

        td {
            padding: 3px 4px;
            border: 1px solid #ddd;
            font-size: 8pt;
            vertical-align: top;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 9pt;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }

        .summary {
            margin-bottom: 8px;
            padding: 6px 8px;
            background-color: #eff6ff;
            border-radius: 3px;
            border-left: 3px solid #3b82f6;
            font-size: 8pt;
        }

        .summary p {
            margin: 2px 0;
            color: #1e40af;
            font-weight: 500;
        }

        .content-cell {
            word-wrap: break-word;
            word-break: break-word;
            white-space: pre-wrap;
            max-width: 400px;
            line-height: 1.2;
            font-size: 7.5pt;
        }
        
        .support-cell {
            word-wrap: break-word;
            word-break: break-word;
            white-space: pre-wrap;
            max-width: 200px;
            line-height: 1.2;
            font-size: 7.5pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Shared Experience Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>
    </div>

    @php
        $hasFilters = !empty($filters['type']) || !empty($filters['search']);
    @endphp

    @if ($hasFilters)
        <div class="filters">
            <h3>Applied Filters:</h3>
            <div>
                @if (!empty($filters['type']))
                    <div class="filter-item">
                        <strong>Experience Type:</strong>
                        <span>{{ $filters['type'] }}</span>
                    </div>
                @endif
                @if (!empty($filters['search']))
                    <div class="filter-item">
                        <strong>Search:</strong>
                        <span>{{ $filters['search'] }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="summary">
        <p><strong>Total Experiences:</strong> {{ $experiences->count() }}</p>
    </div>

    @if ($experiences->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 15%;">Student</th>
                    <th style="width: 20%;">Experience Type</th>
                    <th style="width: 35%;">Content</th>
                    <th style="width: 15%;">Type of Support</th>
                    <th style="width: 10%;">Date Shared</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($experiences as $index => $experience)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $experience->is_anonymously ? 'Anonymous' : 'Student' }}</td>
                        <td>{{ $experience->type_experience ?? '—' }}</td>
                        <td class="content-cell">{{ $experience->content ?? '—' }}</td>
                        <td class="support-cell">{{ $experience->type_of_support ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($experience->created_at)->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No shared experiences found matching the applied filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated report. No signature required.</p>
    </div>
</body>
</html>

