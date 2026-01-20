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
                                <th width="20%">Equipment</th>
                                <th width="15%">Assignee</th>
                                <th width="15%">Last Service Date</th>
                                <th width="15%">Next Service Due</th>
                                <th width="10%">Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenances as $m)
                                <tr id="row-{{ $m->id }}">
                                    <td>{{ $m->equipment->name ?? '-' }}</td>
                                    <td>{{ $m->assignee->name ?? '-' }}</td>
                                    <td>{{ $m->last_service_date ? $m->last_service_date->format('Y-m-d H:i') : '-' }}</td>
                                    <td>
                                        {{ $m->next_service_due ? $m->next_service_due->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $isDue = now()->greaterThanOrEqualTo($m->next_service_due);
                                            $isClose = now()->addDays(2)->greaterThanOrEqualTo($m->next_service_due);
                                        @endphp
                                        <span class="badge bg-{{ $isDue ? 'danger' : ($isClose ? 'warning' : 'success') }}">
                                            {{ $isDue ? 'Overdue' : ($isClose ? 'Upcoming' : 'OK') }}
                                        </span>
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

    <!-- Complete Modal -->
    <div class="modal fade" id="completeModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="completeForm">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title text-white">Complete Maintenance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="maintenanceId">
                        <div class="alert alert-info">
                            Marking as complete will set:
                            <ul class="mb-0">
                                <li>Last Service = NOW</li>
                                <li>Next Service = NOW + 1500 Hours</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea id="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Mark as Completed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.complete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;

                    document.getElementById('maintenanceId').value = id;

                    new bootstrap.Modal(document.getElementById('completeModal')).show();
                });
            });

            document.getElementById('completeForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let id = document.getElementById('maintenanceId').value;
                let currentHm = document.getElementById('currentHm').value;
                let notes = document.getElementById('notes').value;

                fetch(`/mekanik/maintenance/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        action: 'complete',
                        notes: notes
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
        </script>
    @endpush
@endsection