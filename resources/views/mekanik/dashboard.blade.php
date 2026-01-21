@extends('layouts.app')

@section('title', 'Mekanik Dashboard')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #ca8a04 0%, #eab308 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-wrench" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Dashboard Mekanik</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🔧 Kelola perbaikan dan maintenance equipment
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #fefce8 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-clipboard-list fs-3 text-warning"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-1">{{ $activeWorkOrders ?? 0 }}</h3>
                    <p class="text-muted mb-0">Active Work Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #fef2f2 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-3 text-danger"></i>
                    </div>
                    <h3 class="fw-bold text-danger mb-1">{{ $urgentRepairs ?? 0 }}</h3>
                    <p class="text-muted mb-0">Urgent Repairs</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #f0fdf4 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle fs-3 text-success"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-1">{{ $completedRepairs ?? 0 }}</h3>
                    <p class="text-muted mb-0">Completed Repairs</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #f0f9ff 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-calendar-day fs-3 text-info"></i>
                    </div>
                    <h3 class="fw-bold text-info mb-1">{{ $scheduledMaintenance ?? 0 }}</h3>
                    <p class="text-muted mb-0">Scheduled Maintenance</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Maintenance Due List --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #fefce8 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">🗓️ Upcoming Maintenance (7 Days)</h5>
                </div>
                <div class="card-body p-4">
                    @if(isset($maintenanceDue) && count($maintenanceDue) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Due Date</th>
                                        <th class="fw-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maintenanceDue as $m)
                                        <tr>
                                            <td class="fw-medium">{{ $m->equipment->name ?? '-' }}</td>
                                            <td>{{ $m->next_service_due ? $m->next_service_due->format('d M Y') : '-' }}</td>
                                            <td>
                                                @if(now()->greaterThanOrEqualTo($m->next_service_due))
                                                    <span class="badge bg-danger rounded-pill">Overdue</span>
                                                @else
                                                    <span class="badge bg-warning rounded-pill">Upcoming</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
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
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #fefce8 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">⚡ Active Repair Tasks</h5>
                </div>
                <div class="card-body p-4">
                    @if(isset($activeRepairTasks) && count($activeRepairTasks) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Task</th>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Priority</th>
                                        <th class="fw-semibold">Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeRepairTasks as $t)
                                        <tr>
                                            <td class="fw-medium">{{ $t->title }}</td>
                                            <td>{{ $t->equipment->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $t->priority == 'high' ? 'danger' : ($t->priority == 'medium' ? 'warning' : 'info') }} rounded-pill">
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
                        <div class="text-center py-4">
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
@endsection