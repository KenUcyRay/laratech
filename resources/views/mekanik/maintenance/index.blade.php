@extends('layouts.app')

@section('title', 'Maintenance Schedule')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Maintenance Schedule</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-calendar-alt"></i> Schedule
                </button>
            </div>
        </div>
    </div>

    <!-- Maintenance Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Scheduled Maintenance</h6>
        </div>
        <div class="card-body">
            @if($maintenances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="25%">Equipment</th>
                                <th width="12%">Type</th>
                                <th width="15%">Last Service</th>
                                <th width="15%">Next Service</th>
                                <th width="13%">Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenances as $m)
                                <tr id="row-{{ $m->id }}">
                                    <td>{{ $m->equipment->name ?? '-' }}</td>
                                    <td>{{ ucfirst($m->schedule_type) }}</td>
                                    <td>{{ $m->last_service ? $m->last_service->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <span class="{{ $m->next_service <= now() ? 'text-danger fw-bold' : '' }}">
                                            {{ $m->next_service ? $m->next_service->format('Y-m-d') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($m->next_service <= now())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-success">Scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success complete-btn" data-id="{{ $m->id }}">
                                            <i class="fas fa-check-double"></i> Complete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Scheduled Maintenance</h5>
                    <p class="text-muted">There are currently no maintenance schedules to display.</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.complete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    if (!confirm('Mark maintenance as completed? This will update the service date.')) return;

                    fetch(`/mekanik/maintenance/${id}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            action: 'complete'
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        });
                });
            });
        </script>
    @endpush
@endsection