@extends('layouts.app')

@section('title', 'Operator Details')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Operator Details: {{ $operator->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.operators.edit', $operator) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
        <a href="{{ route('admin.operators.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Operators
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
                        <p><strong>Full Name:</strong> {{ $operator->name }}</p>
                        <p><strong>Username:</strong> {{ $operator->username }}</p>
                        <p><strong>Role:</strong> <span class="badge bg-warning">{{ ucfirst($operator->role) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            @if($operator->deleted_at)
                                <span class="badge bg-secondary">Deleted</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </p>
                        <p><strong>Created:</strong> {{ $operator->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $operator->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Summary (if Task model exists) -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Tasks Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-secondary">0</h4>
                            <small>Todo</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning">0</h4>
                            <small>In Progress</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success">0</h4>
                            <small>Completed</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary">0</h4>
                            <small>Total</small>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Task tracking will be available when Task module is implemented</small>
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
                    <a href="{{ route('admin.operators.edit', $operator) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Operator
                    </a>
                    @if(!$operator->deleted_at)
                        <form action="{{ route('admin.operators.destroy', $operator) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Delete this operator?')">
                                <i class="fas fa-trash"></i> Delete Operator
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
                            <p class="timeline-text">{{ $operator->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @if($operator->updated_at != $operator->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Last Updated</h6>
                                <p class="timeline-text">{{ $operator->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
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