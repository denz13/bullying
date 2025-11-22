<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #6b7280;
        }

        .filters {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #4f46e5;
        }

        .filters h3 {
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 10px;
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
            margin-top: 20px;
            background-color: #fff;
        }

        thead {
            background-color: #4f46e5;
            color: #fff;
        }

        th {
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-investigating {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-resolved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-closed {
            background-color: #f3f4f6;
            color: #374151;
        }

        .badge-low {
            background-color: #f3f4f6;
            color: #374151;
        }

        .badge-medium {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-high {
            background-color: #fed7aa;
            color: #9a3412;
        }

        .badge-urgent {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }

        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #eff6ff;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .summary p {
            margin: 5px 0;
            color: #1e40af;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Incident Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>
    </div>

    @php
        $hasFilters = !empty($filters['status']) || !empty($filters['date_from']) || !empty($filters['date_to']) || !empty($filters['search']);
    @endphp

    @if ($hasFilters)
        <div class="filters">
            <h3>Applied Filters:</h3>
            <div>
                @if (!empty($filters['status']))
                    <div class="filter-item">
                        <strong>Status:</strong>
                        <span>{{ ucfirst($filters['status']) }}</span>
                    </div>
                @endif
                @if (!empty($filters['date_from']) || !empty($filters['date_to']))
                    <div class="filter-item">
                        <strong>Date Range:</strong>
                        <span>
                            @if (!empty($filters['date_from']) && !empty($filters['date_to']))
                                {{ \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') }} - {{ \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') }}
                            @elseif (!empty($filters['date_from']))
                                From {{ \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') }}
                            @elseif (!empty($filters['date_to']))
                                Until {{ \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') }}
                            @endif
                        </span>
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
        <p><strong>Total Incidents:</strong> {{ $incidents->count() }}</p>
    </div>

    @if ($incidents->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 20%;">Student</th>
                    <th style="width: 20%;">Incident Type</th>
                    <th style="width: 15%;">Date Reported</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 12%;">Priority</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidents as $index => $incident)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $incident->student }}</td>
                        <td>{{ $incident->incident_type }}</td>
                        <td>{{ \Carbon\Carbon::parse($incident->date_reported)->format('M d, Y') }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($incident->status) }}">
                                {{ ucfirst($incident->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ strtolower($incident->priority) }}">
                                {{ ucfirst($incident->priority) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>No incidents found matching the applied filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated report. No signature required.</p>
    </div>
</body>
</html>

