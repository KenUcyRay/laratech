@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Reports</h4>
            <div>
                <a href="{{ route('mekanik.reports.index', ['severity' => 'high']) }}" class="btn btn-sm btn-danger">High
                    Severity</a>
                <a href="{{ route('mekanik.reports.index') }}" class="btn btn-sm btn-secondary">All</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Equipment</th>
                            <th>Reporter</th>
                            <th>Severity</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $report->equipment->name ?? '-' }}</td>
                                <td>{{ $report->reporter->name ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $report->severity == 'high' ? 'danger' : ($report->severity == 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($report->severity) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($report->description, 50) }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $report->status == 'resolved' ? 'success' : ($report->status == 'processing' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($report->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>
                                    @if(!$report->task_id && $report->status != 'resolved')
                                        <button class="btn btn-sm btn-primary assign-task-btn" data-id="{{ $report->id }}">
                                            Assign Task
                                        </button>
                                    @elseif($report->task_id)
                                        <a href="#" class="btn btn-sm btn-info">View Task</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection