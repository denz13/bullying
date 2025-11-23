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
            color: #000;
            padding: 15px;
            margin-left: 20px;
            margin-right: 20px;
            line-height: 1.5;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            position: relative;
        }

        .student-image-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 120px;
            height: 120px;
            border: 2px solidrgb(255, 255, 255);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }

        .student-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .report-date {
            font-size: 12px;
            color: #333;
            font-weight: 600;
        }

        .system-name {
            font-size: 12px;
            color: #333;
            font-weight: 700;
        }

        .main-title {
            text-align: center;
            margin: 10px 0 8px 0;
        }

        .main-title h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1a4b84;
            margin-bottom: 3px;
        }

        .main-title p {
            font-size: 14px;
            color: #000;
            font-weight: 600;
        }

        .title-divider {
            width: 100%;
            height: 2px;
            background-color: #1a4b84;
            margin: 10px 0 15px 0;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1a4b84;
            margin-bottom: 8px;
            border-bottom: 2px solid #1a4b84;
            padding-bottom: 3px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 8px;
        }

        .info-item {
            margin-bottom: 6px;
        }

        .info-label {
            font-weight: 700;
            color: #333;
            margin-bottom: 0;
            font-size: 12px;
            display: inline;
        }

        .info-value {
            color: #000;
            font-size: 13px;
            font-weight: 600;
            display: inline;
            margin-left: 5px;
        }

        .situation-content,
        .resolution-content {
            color: #000;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.6;
            margin-top: 5px;
            text-align: justify;
        }

        .acknowledgments {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #1a4b84;
            margin: 12px 0;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.6;
            color: #000;
        }

        .acknowledgments strong {
            font-weight: 700;
            font-size: 13px;
            color: #1a4b84;
        }

        .signatures-container {
            display: table !important;
            width: 100% !important;
            margin-top: 15px;
            margin-bottom: 0;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
        }

        .signature-block {
            text-align: center;
            width: 50%;
            display: table-cell !important;
            vertical-align: top !important;
            padding-right: 15px;
            height: auto;
        }
        
        .signature-block:last-child {
            padding-right: 0;
            padding-left: 15px;
        }

        .signature-space {
            min-height: 50px;
            margin-bottom: 8px;
            display: block;
        }

        .signature-name {
            font-weight: 700;
            color: #000;
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 13px;
            display: block;
            min-height: 16px;
            line-height: 16px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            border-bottom: none;
            border-left: none;
            border-right: none;
            margin-top: 0;
            margin-bottom: 5px;
            padding-top: 0;
            padding-bottom: 0;
            width: 100%;
            min-height: 1px;
            height: 1px;
            display: block;
            overflow: visible;
            clear: both;
        }

        .signature-label {
            color: #333;
            font-size: 11px;
            margin-top: 0;
            font-weight: 600;
            display: block;
            text-align: center;
        }

        .counselor-signature {
            text-align: center;
            margin-top: 15px;
        }

        .counselor-signature-block {
            display: inline-block;
            width: 60%;
        }

        .counselor-signature .signature-space {
            min-height: 50px;
            margin-bottom: 8px;
            display: block;
        }

        .counselor-signature .signature-name {
            text-align: center;
            font-weight: 700;
            color: #000;
            font-size: 13px;
            margin-top: 0;
            margin-bottom: 4px;
        }

        .counselor-signature .signature-line {
            border-top: 1px solid #333;
            margin-top: 0;
            margin-bottom: 4px;
            padding-top: 0;
            width: 100%;
            height: 1px;
        }

        .counselor-signature .signature-label {
            text-align: center;
            color: #333;
            font-size: 11px;
            margin-top: 0;
            font-weight: 600;
        }

        .footer {
            margin-top: 60px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #333;
            font-size: 11px;
            font-weight: 500;
            line-height: 1.5;
        }

        .case-report {
            page-break-after: always;
            margin-bottom: 20px;
        }

        .case-report:last-child {
            page-break-after: auto;
        }

        .filters-summary {
            margin-bottom: 20px;
            padding: 12px;
            background-color: #f0f9ff;
            border-left: 4px solid #1a4b84;
            font-size: 11px;
        }

        .filters-summary strong {
            color: #1a4b84;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            font-style: italic;
            font-size: 14px;
        }

        @media print {
            .case-report {
                page-break-after: always;
            }
            .case-report:last-child {
                page-break-after: auto;
            }
            .signatures-container {
                display: table !important;
                width: 100% !important;
                table-layout: fixed !important;
                border-collapse: separate !important;
                border-spacing: 0 !important;
            }
            .signature-block {
                display: table-cell !important;
                width: 50% !important;
                vertical-align: top !important;
                text-align: center !important;
            }
            .signature-space {
                min-height: 50px !important;
                margin-bottom: 8px !important;
                display: block !important;
            }
            .signature-name {
                margin-top: 0 !important;
                margin-bottom: 5px !important;
                min-height: 18px !important;
                line-height: 18px !important;
                text-align: center !important;
            }
            .signature-line {
                border-top: 1px solid #333 !important;
                margin-top: 0 !important;
                margin-bottom: 5px !important;
                width: 100% !important;
                height: 1px !important;
                display: block !important;
            }
            .signature-label {
                text-align: center !important;
            }
            body {
                color: #000 !important;
                margin-left: 20px !important;
                margin-right: 20px !important;
            }
            .info-value {
                font-weight: 600 !important;
                color: #000 !important;
            }
            .info-label {
                font-weight: 700 !important;
                color: #000 !important;
            }
            .situation-content,
            .resolution-content {
                font-weight: 500 !important;
                color: #000 !important;
            }
        }
    </style>
</head>
<body>
    @if ($incidents->count() > 0)
        @foreach ($incidents as $index => $incident)
            <div class="case-report">
                <div class="report-header">
                    <div>
                        <div class="report-date">{{ \Carbon\Carbon::now()->format('m/d/y, g:i A') }}</div>
                        <div class="system-name">Guidance Office Case Resolution System</div>
                    </div>
                    <div class="student-image-container">
                        @if ($incident->student_image)
                            <img src="{{ $incident->student_image }}" alt="{{ $incident->student }}">
                        @endif
                    </div>
                </div>

                <div class="main-title">
                    <h1>Guidance Office Case Resolution Report</h1>
                    <p>Immaculate Conception School of Naic Inc.</p>
                    <p>Student Support and Development</p>
                </div>

                <div class="title-divider"></div>

                <div class="section">
                    <div class="section-title">Student Information</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Student Name:</span>
                            <span class="info-value">{{ $incident->student }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Department:</span>
                            <span class="info-value">{{ $incident->department ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Grade Level:</span>
                            <span class="info-value">{{ $incident->grade_section ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Case Details</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Case ID:</span>
                            <span class="info-value">CASE-{{ str_pad($incident->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Case Type:</span>
                            <span class="info-value">{{ $incident->incident_type }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date of Incident:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($incident->date_reported)->format('m/d/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="info-value">{{ ucfirst($incident->status) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Priority:</span>
                            <span class="info-value">{{ ucfirst($incident->priority) }}</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Situation Overview</div>
                    <div class="situation-content">
                        Incident reported on {{ \Carbon\Carbon::parse($incident->date_reported)->format('F d, Y') }}. 
                        Status: {{ ucfirst($incident->status) }}. 
                        Priority level: {{ ucfirst($incident->priority) }}.
                        @if (!empty($incident->remarks))
                            <br>Remarks: {{ $incident->remarks }}
                        @endif
                    </div>
                </div>

                <!-- <div class="section">
                    <div class="section-title">Resolution and Support</div>
                    <div class="resolution-content">
                        This case is currently under {{ strtolower($incident->status) }} status. 
                        Appropriate actions are being taken to address the incident and provide necessary support to the student.
                    </div>
                </div> -->

                <div class="acknowledgments">
                    <strong>Acknowledgments:</strong><br>
                    This case has been documented through the Guidance Office Case Resolution System. 
                    All necessary actions are being taken to address the concerns raised and provide appropriate support to the student.
                </div>

                <div class="signatures-container">
                    <div class="signature-block">
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $incident->student }}</div>
                        <div class="signature-line"></div>
                        <div class="signature-label">Student Signature</div>
                    </div>
                    
                    <div class="signature-block">
                        <div class="signature-space"></div>
                        <div class="signature-name"></div>
                        <div class="signature-line"></div>
                        <div class="signature-label">Parent/Guardian Signature</div>
                    </div>
                </div>

                <div class="counselor-signature">
                    <div class="counselor-signature-block">
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $currentUser->name ?? '' }}</div>
                        <div class="signature-line"></div>
                        <div class="signature-label">School Counselor</div>
                    </div>
                </div>

                <div class="footer">
                    <p>Report generated on {{ \Carbon\Carbon::now()->format('m/d/Y') }} by the School Guidance Office</p>
                    <p>This document is confidential and intended only for the parties involved</p>
                </div>
            </div>
        @endforeach

        @php
            $hasFilters = !empty($filters['status']) || !empty($filters['date_from']) || !empty($filters['date_to']) || !empty($filters['search']);
        @endphp

        @if ($hasFilters)
            <div class="filters-summary" style="page-break-before: always; margin-top: 40px;">
                <strong>Report Filters Applied:</strong><br>
                @if (!empty($filters['status']))
                    Status: {{ ucfirst($filters['status']) }}<br>
                @endif
                @if (!empty($filters['date_from']) || !empty($filters['date_to']))
                    Date Range: 
                    @if (!empty($filters['date_from']) && !empty($filters['date_to']))
                        {{ \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') }} - {{ \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') }}
                    @elseif (!empty($filters['date_from']))
                        From {{ \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') }}
                    @elseif (!empty($filters['date_to']))
                        Until {{ \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') }}
                    @endif
                    <br>
                @endif
                @if (!empty($filters['search']))
                    Search: {{ $filters['search'] }}<br>
                @endif
                <strong>Total Cases:</strong> {{ $incidents->count() }}
            </div>
        @endif
    @else
        <div class="report-header">
            <div>
                <div class="report-date">{{ \Carbon\Carbon::now()->format('m/d/y, g:i A') }}</div>
                <div class="system-name">Guidance Office Case Resolution System</div>
            </div>
            <div class="student-image-container">
            </div>
        </div>

        <div class="main-title">
            <h1>Guidance Office Case Resolution Report</h1>
            <p>Immaculate Conception School of Naic Inc.</p>
            <p>Student Support and Development</p>
        </div>

        <div class="title-divider"></div>

        <div class="no-data">
            <p>No incidents found matching the applied filters.</p>
        </div>
    @endif
</body>
</html>
