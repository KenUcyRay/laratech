@extends('layouts.app')

@section('title', 'Report Details')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Report Details #{{ $report->id }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-warning">
                <i class="fas fa-edit"></i> Update Status
            </button>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Reports
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Report Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Title:</strong> {{ $report->title ?? 'N/A' }}</p>
                        <p><strong>Equipment:</strong> {{ $report->equipment->name ?? 'N/A' }}</p>
                        <p><strong>Reporter:</strong> {{ $report->reporter->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Severity:</strong> 
                            <span class="badge bg-{{ $report->severity === 'high' ? 'danger' : ($report->severity === 'medium' ? 'warning' : 'success') }}">
                                {{ ucfirst($report->severity ?? 'low') }}
                            </span>
                        </p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $report->status === 'resolved' ? 'success' : ($report->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $report->status ?? 'open')) }}
                            </span>
                        </p>
                        <p><strong>Created:</strong> {{ $report->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Description</h5>
            </div>
            <div class="card-body">
                <p>{{ $report->description ?? 'No description available.' }}</p>
            </div>
        </div>

        <!-- Images Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Attachments</h5>
            </div>
            <div class="card-body">
                @if(isset($report->images) && $report->images->count() > 0)
                    <div class="row">
                        @foreach($report->images as $image)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="{{ $image->path }}" class="card-img-top" alt="Report Image" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <small class="text-muted">{{ $image->filename ?? 'Image' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No attachments available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments/Updates Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Updates & Comments</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Report Created</h6>
                            <p class="timeline-text">{{ $report->created_at->format('M d, Y H:i') }}</p>
                            <small class="text-muted">by {{ $report->reporter->name ?? 'Unknown' }}</small>
                        </div>
                    </div>
                    @if($report->updated_at != $report->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Last Updated</h6>
                                <p class="timeline-text">{{ $report->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <h6>Add Comment</h6>
                    <form>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm">Add Comment</button>
                    </form>
                    <small class="text-muted">Comment functionality will be available when the Report module is fully implemented.</small>
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
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-check"></i> Mark as Resolved
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-clock"></i> Mark in Progress
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-user-plus"></i> Assign to Mekanik
                    </button>
                    <button type="button" class="btn btn-secondary">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
                <small class="text-muted mt-2 d-block">Actions will be functional when the Report module is implemented.</small>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Report Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Report ID:</strong> {{ $report->id }}</p>
                <p><strong>Priority:</strong> 
                    <span class="badge bg-{{ $report->severity === 'high' ? 'danger' : ($report->severity === 'medium' ? 'warning' : 'success') }}">
                        {{ ucfirst($report->severity ?? 'low') }}
                    </span>
                </p>
                <p><strong>Category:</strong> {{ $report->category ?? 'General' }}</p>
                <p><strong>Location:</strong> {{ $report->location ?? 'N/A' }}</p>
                <p><strong>Estimated Cost:</strong> {{ $report->estimated_cost ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Related Information</h5>
            </div>
            <div class="card-body">
                <h6>Equipment Details:</h6>
                <p><strong>Name:</strong> {{ $report->equipment->name ?? 'N/A' }}</p>
                <p><strong>Type:</strong> {{ $report->equipment->type->name ?? 'N/A' }}</p>
                <p><strong>Serial:</strong> {{ $report->equipment->serial_number ?? 'N/A' }}</p>
                
                <hr>
                
                <h6>Reporter Details:</h6>
                <p><strong>Name:</strong> {{ $report->reporter->name ?? 'N/A' }}</p>
                <p><strong>Role:</strong> {{ $report->reporter->role ?? 'N/A' }}</p>
                <p><strong>Contact:</strong> {{ $report->reporter->email ?? 'N/A' }}</p>
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