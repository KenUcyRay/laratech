@extends('layouts.app')

@section('title', 'Mekanik Details')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mekanik Details: {{ $mekanik->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.mekaniks.edit', $mekanik) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
        <a href="{{ route('admin.mekaniks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Mekaniks
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Full Name:</strong> {{ $mekanik->name }}</p>
                        <p><strong>Username:</strong> {{ $mekanik->username }}</p>
                        <p><strong>Role:</strong> <span class="badge bg-info">{{ ucfirst($mekanik->role) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            @if($mekanik->deleted_at)
                                <span class="badge bg-secondary">Deleted</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </p>
                        <p><strong>Created:</strong> {{ $mekanik->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $mekanik->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Work Summary -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Work Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning">0</h4>
                            <small>Active Work Orders</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success">0</h4>
                            <small>Completed Repairs</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info">0</h4>
                            <small>Maintenance Done</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-danger">0</h4>
                            <small>Urgent Repairs</small>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Work tracking will be available when Work Order module is implemented</small>
                </div>
            </div>
        </div>

        <!-- Skills & Specializations -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Skills & Specializations</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Technical Skills:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-wrench text-info"></i> Mechanical Repair</li>
                            <li><i class="fas fa-cogs text-info"></i> Equipment Maintenance</li>
                            <li><i class="fas fa-tools text-info"></i> Troubleshooting</li>
                            <li><i class="fas fa-bolt text-info"></i> Electrical Systems</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Equipment Types:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-truck text-info"></i> Heavy Machinery</li>
                            <li><i class="fas fa-car text-info"></i> Vehicles</li>
                            <li><i class="fas fa-industry text-info"></i> Industrial Equipment</li>
                            <li><i class="fas fa-microchip text-info"></i> Electronic Systems</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Skills management will be available in future updates</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.mekaniks.edit', $mekanik) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Mekanik
                    </a>
                    @if(!$mekanik->deleted_at)
                        <form action="{{ route('admin.mekaniks.destroy', $mekanik) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Delete this mekanik?')">
                                <i class="fas fa-trash"></i> Delete Mekanik
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Activity Log</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Account Created</h6>
                            <p class="timeline-text">{{ $mekanik->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @if($mekanik->updated_at != $mekanik->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Last Updated</h6>
                                <p class="timeline-text">{{ $mekanik->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($mekanik->deleted_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Account Deleted</h6>
                                <p class="timeline-text">{{ $mekanik->deleted_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Performance</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-success">0</h5>
                        <small>Jobs Completed</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-info">0</h5>
                        <small>Avg. Rating</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <small class="text-muted">Performance tracking will be available when Work Order module is implemented</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 17px;
    width: 2px;
    height: calc(100% + 5px);
    background-color: #dee2e6;
}
.timeline-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}
.timeline-text {
    font-size: 12px;
    color: #6c757d;
    margin-bottom: 0;
}
</style>
@endpush