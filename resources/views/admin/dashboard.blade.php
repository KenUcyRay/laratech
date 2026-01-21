@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@push('styles')
<style>
.stat-card {
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-2px);
}
.chart-container {
    position: relative;
    height: 300px;
}
/* Menghilangkan indikator mengetik */
* {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
input, textarea {
    -webkit-user-select: text;
    -moz-user-select: text;
    -ms-user-select: text;
    user-select: text;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Operators
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeOperators }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-desktop fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Active Mekaniks
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeMekaniks }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wrench fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Tasks
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingTasks }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Equipment Status Chart -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Equipment Status</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Idle: {{ $equipmentStatus['idle'] }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Operasi: {{ $equipmentStatus['operasi'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Rusak: {{ $equipmentStatus['rusak'] }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Servis: {{ $equipmentStatus['servis'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <h4 class="text-muted">Total Equipment: {{ $totalEquipment }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Summary Chart -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Task Summary</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Todo: {{ $taskSummary['todo'] }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Doing: {{ $taskSummary['doing'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Done: {{ $taskSummary['done'] }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="small">Cancelled: {{ $taskSummary['cancelled'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <h4 class="text-muted">Total Tasks: {{ $taskSummary['total'] }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row">
    <!-- Maintenance Due -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Maintenance Due (Next 7 Days)</h6>
                <span class="badge bg-warning">{{ $maintenanceDue->count() }} items</span>
            </div>
            <div class="card-body">
                @if($maintenanceDue->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Next Service Due</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenanceDue as $maintenance)
                                    <tr>
                                        <td>{{ $maintenance->equipment->name ?? 'N/A' }}</td>
                                        <td>{{ $maintenance->next_service_due ? $maintenance->next_service_due->format('M d, Y') : '-' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $maintenance->next_service_due && $maintenance->next_service_due->isPast() ? 'danger' : 'warning' }}">
                                                {{ $maintenance->next_service_due && $maintenance->next_service_due->isPast() ? 'Overdue' : 'Due Soon' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-muted">No maintenance due in the next 7 days</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Report Severity -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Report Severity</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small font-weight-bold">High Priority</span>
                        <span class="small">{{ $reportSeverity['high'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: {{ $reportSeverity['total'] > 0 ? ($reportSeverity['high'] / $reportSeverity['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small font-weight-bold">Medium Priority</span>
                        <span class="small">{{ $reportSeverity['medium'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $reportSeverity['total'] > 0 ? ($reportSeverity['medium'] / $reportSeverity['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small font-weight-bold">Low Priority</span>
                        <span class="small">{{ $reportSeverity['low'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $reportSeverity['total'] > 0 ? ($reportSeverity['low'] / $reportSeverity['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <h5 class="text-muted">Total Reports: {{ $reportSeverity['total'] }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
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
</style>
@endpush