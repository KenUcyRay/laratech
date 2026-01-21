@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-user-tie" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Manager Dashboard</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        👔 Kelola tim dan monitor performa operasional
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #3b82f6 0%, #1d4ed8 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-tasks fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $totalTasks }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-clock fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $pendingTasks }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Pending Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #10b981 0%, #059669 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $completedTasks }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Completed Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #06b6d4 0%, #0891b2 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-users fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $totalOperators + $totalMekaniks }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Team</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0 text-gray-800">📊 Equipment Status</h5>
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
                        <h4 class="text-muted">Total Equipment: {{ array_sum($equipmentStatus) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0 text-gray-800">👥 Team Overview</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                    <span class="small">Operators: {{ $totalOperators }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                    <span class="small">Mekaniks: {{ $totalMekaniks }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <h4 class="text-muted">Total Team: {{ $totalOperators + $totalMekaniks }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables Row --}}
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-gray-800">📋 Recent Tasks</h5>
                        <span class="badge bg-primary rounded-pill">{{ $recentTasks->count() }} tasks</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($recentTasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Task</th>
                                        <th class="fw-semibold">Assignee</th>
                                        <th class="fw-semibold">Status</th>
                                        <th class="fw-semibold">Equipment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTasks as $task)
                                        <tr>
                                            <td class="fw-medium">{{ $task->title }}</td>
                                            <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                            <td>
                                                @if($task->status == 'todo')
                                                    <span class="badge bg-secondary rounded-pill">Todo</span>
                                                @elseif($task->status == 'doing')
                                                    <span class="badge bg-warning rounded-pill">Doing</span>
                                                @elseif($task->status == 'done')
                                                    <span class="badge bg-success rounded-pill">Done</span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>{{ $task->equipment->name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent tasks found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-gray-800">🚨 Critical Reports</h5>
                        <span class="badge bg-danger rounded-pill">{{ $criticalReports->count() }} high priority</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($criticalReports->count() > 0)
                        @foreach($criticalReports as $report)
                            <div class="mb-3 p-3 rounded-3 bg-light shadow-sm border-start border-4 border-danger">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-bold">{{ $report->title }}</h6>
                                    <span class="badge bg-danger rounded-pill">High</span>
                                </div>
                                <p class="small text-muted mb-1">{{ Str::limit($report->description, 60) }}</p>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">{{ $report->equipment->name ?? 'N/A' }}</small>
                                    <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-muted">No critical reports</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection