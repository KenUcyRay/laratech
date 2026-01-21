<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reports Export - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
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
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .badge-high { background-color: #dc3545; }
        .badge-medium { background-color: #ffc107; color: #000; }
        .badge-low { background-color: #17a2b8; }
        .badge-secondary { background-color: #6c757d; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Equipment Reports</h1>
        <p>Generated on {{ now()->format('d F Y, H:i') }}</p>
        <p>Laratech Equipment Management System</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $reportStats['total'] }}</div>
            <div class="stat-label">Total Reports</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $reportStats['high'] }}</div>
            <div class="stat-label">High Priority</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $reportStats['medium'] }}</div>
            <div class="stat-label">Medium Priority</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $reportStats['low'] }}</div>
            <div class="stat-label">Low Priority</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Equipment</th>
                <th>Reporter</th>
                <th>Description</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->equipment->name ?? 'N/A' }}</td>
                <td>{{ $report->reporter->name ?? 'N/A' }}</td>
                <td>{{ Str::limit($report->description, 80) }}</td>
                <td>
                    @if($report->severity == 'high')
                        <span class="badge badge-high">High</span>
                    @elseif($report->severity == 'medium')
                        <span class="badge badge-medium">Medium</span>
                    @else
                        <span class="badge badge-low">Low</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-secondary">{{ ucfirst($report->status) }}</span>
                </td>
                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report contains {{ $reports->count() }} records</p>
        <p>Laratech Equipment Management System - Manager Dashboard</p>
    </div>
</body>
</html>