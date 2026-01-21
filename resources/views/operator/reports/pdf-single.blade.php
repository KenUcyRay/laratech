<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kerusakan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 6px;
            vertical-align: top;
        }
        .label {
            width: 30%;
            font-weight: bold;
        }
        .box {
            border: 1px solid #000;
            padding: 10px;
        }
    </style>
</head>
<body>

<h2>LAPORAN KERUSAKAN</h2>

<table class="box">
    <tr>
        <td class="label">Equipment</td>
        <td>{{ $report->equipment->name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Severity</td>
        <td>{{ strtoupper($report->severity) }}</td>
    </tr>
    <tr>
        <td class="label">Deskripsi</td>
        <td>{{ $report->description }}</td>
    </tr>
    <tr>
        <td class="label">Operator</td>
        <td>{{ $report->user->name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Tanggal</td>
        <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
    </tr>
</table>

<br><br>
<p>Ditandatangani,</p>
<br><br>
<p>________________________</p>

</body>
</html>
