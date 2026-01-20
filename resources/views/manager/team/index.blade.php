@extends('layouts.app')

@section('title', 'Team Management')

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
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-users me-2"></i>Team Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>
</div>

<!-- Team Statistics -->
<div class="row mb-4">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Operators
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $operators->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-desktop fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Mekaniks
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mekaniks->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wrench fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Operators Section -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Operators</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Total Tasks</th>
                        <th>Pending Tasks</th>
                        <th>Completed Tasks</th>
                        <th>Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operators as $operator)
                    <tr>
                        <td>{{ $operator->name }}</td>
                        <td>{{ $operator->username }}</td>
                        <td>{{ $operator->total_tasks }}</td>
                        <td>
                            <span class="badge bg-warning">{{ $operator->pending_tasks }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $operator->completed_tasks }}</span>
                        </td>
                        <td>
                            @php
                                $performance = $operator->total_tasks > 0 ? 
                                    round(($operator->completed_tasks / $operator->total_tasks) * 100) : 0;
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar 
                                    @if($performance >= 80) bg-success 
                                    @elseif($performance >= 60) bg-warning 
                                    @else bg-danger @endif" 
                                    style="width: {{ $performance }}%">
                                    {{ $performance }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mekaniks Section -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Mekaniks</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Total Tasks</th>
                        <th>Pending Tasks</th>
                        <th>Completed Tasks</th>
                        <th>Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mekaniks as $mekanik)
                    <tr>
                        <td>{{ $mekanik->name }}</td>
                        <td>{{ $mekanik->username }}</td>
                        <td>{{ $mekanik->total_tasks }}</td>
                        <td>
                            <span class="badge bg-warning">{{ $mekanik->pending_tasks }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $mekanik->completed_tasks }}</span>
                        </td>
                        <td>
                            @php
                                $performance = $mekanik->total_tasks > 0 ? 
                                    round(($mekanik->completed_tasks / $mekanik->total_tasks) * 100) : 0;
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar 
                                    @if($performance >= 80) bg-success 
                                    @elseif($performance >= 60) bg-warning 
                                    @else bg-danger @endif" 
                                    style="width: {{ $performance }}%">
                                    {{ $performance }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection