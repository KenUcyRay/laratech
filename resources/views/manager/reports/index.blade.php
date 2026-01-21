@extends('layouts.app')

@section('title', 'Reports')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #7c3aed !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chart-area me-2"></i>Reports</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>
</div>

<!-- Report Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Reports</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reportStats['total'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">High Priority</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reportStats['high'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Medium Priority</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reportStats['medium'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Low Priority</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reportStats['low'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reports Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Reports</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Reporter</th>
                        <th>Description</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->equipment->name ?? 'N/A' }}</td>
                        <td>{{ $report->reporter->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($report->description, 50) }}</td>
                        <td>
                            @if($report->severity == 'high')
                                <span class="badge bg-danger">High</span>
                            @elseif($report->severity == 'medium')
                                <span class="badge bg-warning">Medium</span>
                            @else
                                <span class="badge bg-info">Low</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($report->status) }}</span>
                        </td>
                        <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('manager.reports.show', $report->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection