@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-tachometer-alt" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Admin Dashboard</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🎛️ Kelola dan pantau seluruh sistem LaraTech
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-users fs-3 text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-1">{{ $totalUsers }}</h3>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-desktop fs-3 text-success"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-1">{{ $activeOperators }}</h3>
                    <p class="text-muted mb-0">Active Operators</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-wrench fs-3 text-info"></i>
                    </div>
                    <h3 class="fw-bold text-info mb-1">{{ $activeMekaniks }}</h3>
                    <p class="text-muted mb-0">Active Mekaniks</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-body p-4 text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-tasks fs-3 text-warning"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-1">{{ $pendingTasks }}</h3>
                    <p class="text-muted mb-0">Pending Tasks</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">📊 Equipment Status</h5>
                </div>
                <div class="card-body p-4">
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
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">📋 Task Summary</h5>
                </div>
                <div class="card-body p-4">
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

    {{-- Tables Row --}}
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">🔧 Maintenance Due (Next 7 Days)</h5>
                        <span class="badge bg-warning rounded-pill">{{ $maintenanceDue->count() }} items</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($maintenanceDue->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Next Service Due</th>
                                        <th class="fw-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maintenanceDue as $maintenance)
                                        <tr>
                                            <td class="fw-medium">{{ $maintenance->equipment->name ?? 'N/A' }}</td>
                                            <td>{{ $maintenance->next_service_due ? $maintenance->next_service_due->format('M d, Y') : '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $maintenance->next_service_due && $maintenance->next_service_due->isPast() ? 'danger' : 'warning' }} rounded-pill">
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
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0">⚠️ Report Severity</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">High Priority</span>
                            <span class="badge bg-danger rounded-pill">{{ $reportSeverity['high'] }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ $reportSeverity['total'] > 0 ? ($reportSeverity['high'] / $reportSeverity['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Medium Priority</span>
                            <span class="badge bg-warning rounded-pill">{{ $reportSeverity['medium'] }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $reportSeverity['total'] > 0 ? ($reportSeverity['medium'] / $reportSeverity['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Low Priority</span>
                            <span class="badge bg-success rounded-pill">{{ $reportSeverity['low'] }}</span>
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

</div>
@endsection