@extends('layouts.app')

@section('title', 'Mekanik Dashboard')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Mekanik</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Active Work Orders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeWorkOrders ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Urgent Repairs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $urgentRepairs ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed Repairs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedRepairs ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Scheduled Maintenance
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $scheduledMaintenance ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Maintenance Due List -->
        <div class="col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Upcoming Maintenance (7 Days)</h6>
                </div>
                <div class="card-body">
                    @if(isset($maintenanceDue) && count($maintenanceDue) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="45%">Equipment</th>
                                        <th width="30%">Due Date</th>
                                        <th width="25%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maintenanceDue as $m)
                                        <tr>
                                            <td>{{ $m->equipment->name ?? '-' }}</td>
                                            <td>{{ $m->next_service_due ? $m->next_service_due->format('d M Y') : '-' }}</td>
                                            <td>
                                                @if(now()->greaterThanOrEqualTo($m->next_service_due))
                                                    <span class="badge bg-danger">Overdue</span>
                                                @else
                                                    <span class="badge bg-warning">Upcoming</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Upcoming Maintenance</h5>
                            <p class="text-muted">All maintenance is up to date.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Active Tasks -->
        <div class="col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Active Repair Tasks</h6>
                </div>
                <div class="card-body">
                    @if(isset($activeRepairTasks) && count($activeRepairTasks) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="35%">Task</th>
                                        <th width="25%">Equipment</th>
                                        <th width="20%">Priority</th>
                                        <th width="20%">Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeRepairTasks as $t)
                                        <tr>
                                            <td>{{ $t->title }}</td>
                                            <td>{{ $t->equipment->name ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $t->priority == 'high' ? 'danger' : ($t->priority == 'medium' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($t->priority) }}
                                                </span>
                                            </td>
                                            <td>{{ $t->due_date ? $t->due_date->format('Y-m-d') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Active Tasks</h5>
                            <p class="text-muted">You're all caught up!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
    </style>
@endpush