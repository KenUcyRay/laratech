@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            @include('components.manager-sidebar')
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Manager Dashboard</h1>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tasks</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTasks }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Tasks</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingTasks }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Tasks</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedTasks }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Team</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOperators + $totalMekaniks }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Status -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Equipment Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="text-success">
                                        <i class="fas fa-circle"></i> Idle: {{ $equipmentStatus['idle'] }}
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="text-primary">
                                        <i class="fas fa-circle"></i> Operasi: {{ $equipmentStatus['operasi'] }}
                                    </div>
                                </div>
                                <div class="col-6 text-center mt-2">
                                    <div class="text-danger">
                                        <i class="fas fa-circle"></i> Rusak: {{ $equipmentStatus['rusak'] }}
                                    </div>
                                </div>
                                <div class="col-6 text-center mt-2">
                                    <div class="text-warning">
                                        <i class="fas fa-circle"></i> Servis: {{ $equipmentStatus['servis'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Tasks</h6>
                        </div>
                        <div class="card-body">
                            @foreach($recentTasks as $task)
                            <div class="d-flex align-items-center mb-2">
                                <div class="mr-3">
                                    @if($task->status == 'todo')
                                        <span class="badge badge-secondary">Todo</span>
                                    @elseif($task->status == 'doing')
                                        <span class="badge badge-warning">Doing</span>
                                    @elseif($task->status == 'done')
                                        <span class="badge badge-success">Done</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $task->title }}</div>
                                    <small class="text-muted">{{ $task->assignee->name ?? 'Unassigned' }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection