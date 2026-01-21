@extends('layouts.app')

@section('title', 'Mekanik Dashboard')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tachometer-alt"
                    style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Dashboard Mekanik</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            📊 Ringkasan aktivitas dan status pekerjaan Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                                    Active Work Orders
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-dark">{{ $activeWorkOrders ?? 0 }}</div>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-clipboard-list fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-2">
                                    Urgent Repairs
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-dark">{{ $urgentRepairs ?? 0 }}</div>
                            </div>
                            <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-exclamation-triangle fs-3 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                    Completed Repairs
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-dark">{{ $completedRepairs ?? 0 }}</div>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                                    Scheduled Maintenance
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-dark">{{ $scheduledMaintenance ?? 0 }}</div>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-calendar-day fs-3 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Cards --}}
        <div class="row g-4">
            {{-- Maintenance Due List --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="fw-bold mb-0">🔧 Upcoming Maintenance (7 Days)</h5>
                    </div>
                    <div class="card-body p-4">
                        @if(isset($maintenanceDue) && count($maintenanceDue) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
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

            {{-- Active Tasks --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="fw-bold mb-0">⚙️ Active Repair Tasks</h5>
                    </div>
                    <div class="card-body p-4">
                        @if(isset($activeRepairTasks) && count($activeRepairTasks) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
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
    </div>

@push('styles')
    <style>
        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush
