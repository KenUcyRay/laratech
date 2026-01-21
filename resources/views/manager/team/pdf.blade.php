<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Team Report - {{ now()->format('Y-m-d') }}</title>
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
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
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
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .badge-primary { background-color: #007bff; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .performance-bar {
            width: 80px;
            height: 15px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            display: inline-block;
            position: relative;
        }
        .performance-fill {
            height: 100%;
            border-radius: 10px;
            font-size: 8px;
            line-height: 15px;
            text-align: center;
            color: white;
            font-weight: bold;
        }
        .performance-success { background-color: #28a745; }
        .performance-warning { background-color: #ffc107; }
        .performance-danger { background-color: #dc3545; }
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
        <h1>Team Performance Report</h1>
        <p>Generated on {{ now()->format('d F Y, H:i') }}</p>
        <p>Laratech Equipment Management System</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $operators->count() }}</div>
            <div class="stat-label">Total Operators</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $mekaniks->count() }}</div>
            <div class="stat-label">Total Mekaniks</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $operators->count() + $mekaniks->count() }}</div>
            <div class="stat-label">Total Team Members</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">🖥️ Operators Performance</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Total Tasks</th>
                    <th>Pending Tasks</th>
                    <th>Completed Tasks</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($operators as $operator)
                <tr>
                    <td>{{ $operator->name }}</td>
                    <td>{{ $operator->username }}</td>
                    <td><span class="badge badge-primary">{{ $operator->total_tasks }}</span></td>
                    <td><span class="badge badge-warning">{{ $operator->pending_tasks }}</span></td>
                    <td><span class="badge badge-success">{{ $operator->completed_tasks }}</span></td>
                    <td>
                        @php
                            $performance = $operator->total_tasks > 0 ? 
                                round(($operator->completed_tasks / $operator->total_tasks) * 100) : 0;
                        @endphp
                        <div class="performance-bar">
                            <div class="performance-fill 
                                @if($performance >= 80) performance-success 
                                @elseif($performance >= 60) performance-warning 
                                @else performance-danger @endif" 
                                style="width: {{ $performance }}%">
                                {{ $performance }}%
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">🔧 Mekaniks Performance</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Total Tasks</th>
                    <th>Pending Tasks</th>
                    <th>Completed Tasks</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mekaniks as $mekanik)
                <tr>
                    <td>{{ $mekanik->name }}</td>
                    <td>{{ $mekanik->username }}</td>
                    <td><span class="badge badge-primary">{{ $mekanik->total_tasks }}</span></td>
                    <td><span class="badge badge-warning">{{ $mekanik->pending_tasks }}</span></td>
                    <td><span class="badge badge-success">{{ $mekanik->completed_tasks }}</span></td>
                    <td>
                        @php
                            $performance = $mekanik->total_tasks > 0 ? 
                                round(($mekanik->completed_tasks / $mekanik->total_tasks) * 100) : 0;
                        @endphp
                        <div class="performance-bar">
                            <div class="performance-fill 
                                @if($performance >= 80) performance-success 
                                @elseif($performance >= 60) performance-warning 
                                @else performance-danger @endif" 
                                style="width: {{ $performance }}%">
                                {{ $performance }}%
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This report contains {{ $operators->count() + $mekaniks->count() }} team members</p>
        <p>Laratech Equipment Management System - Manager Dashboard</p>
    </div>
</body>
</html>