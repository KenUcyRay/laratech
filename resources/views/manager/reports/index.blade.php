@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            @include('components.manager-sidebar')
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Reports</h1>
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
                                            <span class="badge badge-danger">High</span>
                                        @elseif($report->severity == 'medium')
                                            <span class="badge badge-warning">Medium</span>
                                        @else
                                            <span class="badge badge-info">Low</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ ucfirst($report->status) }}</span>
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
        </div>
    </div>
</div>
@endsection