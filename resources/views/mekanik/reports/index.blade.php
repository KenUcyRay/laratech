@extends('layouts.app')

@section('title', 'Laporan & Issues')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Reported Issues</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-3">
        <a href="{{ route('mekanik.reports.index') }}"
            class="btn btn-sm {{ !request('status') && !request('severity') ? 'btn-secondary' : 'btn-outline-secondary' }}">All</a>
        <a href="{{ route('mekanik.reports.index', ['status' => 'pending']) }}"
            class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pending</a>
        <a href="{{ route('mekanik.reports.index', ['severity' => 'high']) }}"
            class="btn btn-sm {{ request('severity') == 'high' ? 'btn-danger' : 'btn-outline-danger' }}">High Priority</a>
    </div>

    <!-- Reports Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Issue Reports</h6>
        </div>
        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Date</th>
                                <th width="18%">Equipment</th>
                                <th width="12%">Reporter</th>
                                <th width="22%">Description</th>
                                <th width="10%">Severity</th>
                                <th width="10%">Status</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr id="row-{{ $report->id }}">
                                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $report->equipment->name ?? '-' }}</td>
                                    <td>{{ $report->reporter->name ?? '-' }}</td>
                                    <td><small>{{ Str::limit($report->description, 40) }}</small></td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $report->severity == 'high' ? 'danger' : ($report->severity == 'medium' ? 'warning' : 'info') }}">
                                            {{ ucfirst($report->severity) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $report->status == 'resolved' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group center" role="group">
                                            @if($report->status != 'resolved' && !$report->task)
                                                <button class="btn btn-sm btn-primary create-task-btn" data-id="{{ $report->id }}"
                                                    title="Create Task">
                                                    <i class="fas fa-tools"></i>
                                                </button>
                                            @endif

                                            <button class="btn btn-sm btn-info update-status-btn text-white"
                                                data-id="{{ $report->id }}" data-status="{{ $report->status }}"
                                                title="Update Status">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if($report->task)
                                                <a href="{{ route('mekanik.work-orders.index') }}" class="btn btn-sm btn-secondary"
                                                    title="View Task">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Reports Found</h5>
                    <p class="text-muted">There are currently no issue reports to display.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="statusForm">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title text-white">Update Report Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="reportId">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select id="reportStatus" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Create Task
            document.querySelectorAll('.create-task-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    if (!confirm('Create a generic repair task for this report?')) return;

                    fetch(`/mekanik/reports/${id}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            action: 'assign_task',
                            notes: 'Auto-generated from report'
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

            // Update Status
            document.querySelectorAll('.update-status-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    let status = this.dataset.status;

                    document.getElementById('reportId').value = id;
                    document.getElementById('reportStatus').value = status;

                    new bootstrap.Modal(document.getElementById('statusModal')).show();
                });
            });

            document.getElementById('statusForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let id = document.getElementById('reportId').value;
                let status = document.getElementById('reportStatus').value;

                fetch(`/mekanik/reports/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        status: status
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