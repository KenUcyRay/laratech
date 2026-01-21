@extends('layouts.app')

@section('title', 'Laporan & Issues')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-clipboard-list"
                    style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Reported Issues</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            📝 Laporan masalah dan kerusakan equipment
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="mb-3">
            <a href="{{ route('mekanik.reports.index') }}"
                class="btn btn-sm {{ !request('status') && !request('severity') ? 'btn-secondary' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('mekanik.reports.index', ['status' => 'pending']) }}"
                class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pending</a>
            <a href="{{ route('mekanik.reports.index', ['severity' => 'high']) }}"
                class="btn btn-sm {{ request('severity') == 'high' ? 'btn-danger' : 'btn-outline-danger' }}">High
                Priority</a>
        </div>

        {{-- Reports Table --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">Date</th>
                                    <th width="18%">Equipment</th>
                                    <th width="12%">Reporter</th>
                                    <th width="22%">Description</th>
                                    <th width="10%">Severity</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Action</th>
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
                                                <button class="btn btn-sm btn-info text-white view-details-btn"
                                                    data-id="{{ $report->id }}" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                @if($report->status != 'resolved' && !$report->task)
                                                    <button class="btn btn-sm btn-primary create-task-btn" data-id="{{ $report->id }}"
                                                        title="Create Task">
                                                        <i class="fas fa-tools"></i>
                                                    </button>
                                                @endif

                                                <button class="btn btn-sm btn-warning update-status-btn text-dark"
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
                    
                    {{-- Pagination --}}
                    @if($reports->hasPages())
                        <div class="d-flex justify-content-end mt-4">
                            {{ $reports->links('custom.mekanik-pagination') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Reports Found</h5>
                        <p class="text-muted">There are currently no issue reports to display.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    </div>
    </div>

    <!-- Updates Status Modal -->
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

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-clipboard-list me-2"></i>Report Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Equipment Info -->
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-left-info shadow-sm py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Equipment
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="detailEquipmentName">-
                                            </div>
                                            <div class="text-muted small mt-1" id="detailEquipmentType">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-truck-moving fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reporter Info -->
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-left-warning shadow-sm py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Reported
                                                By</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="detailReporterName">
                                                -
                                            </div>
                                            <div class="text-muted small mt-1" id="detailDate">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="m-0 font-weight-bold text-secondary">Description</h6>
                        </div>
                        <div class="card-body bg-white">
                            <p class="card-text" id="detailDescription" style="white-space: pre-wrap;">-</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="badge" id="detailSeverityBadge"></span>
                            <span class="badge" id="detailStatusBadge"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Optional: Add generic task creation button if needed here too -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Pass PHP data to JS
            const reportsData = @json($reports->keyBy('id'));

            // View Details
            document.querySelectorAll('.view-details-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    let report = reportsData[id];

                    if (report) {
                        // Populate modal
                        document.getElementById('detailEquipmentName').textContent = report.equipment ? report.equipment.name : 'Unknown Equipment';
                        document.getElementById('detailEquipmentType').textContent = report.equipment ? (report.equipment.type || 'Type not specified') : '-';

                        document.getElementById('detailReporterName').textContent = report.reporter ? report.reporter.name : 'Unknown Reporter';
                        document.getElementById('detailDate').textContent = new Date(report.created_at).toLocaleDateString() + ' ' + new Date(report.created_at).toLocaleTimeString();

                        document.getElementById('detailDescription').textContent = report.description;

                        // Badges
                        let severityBadge = document.getElementById('detailSeverityBadge');
                        severityBadge.className = 'badge user-select-none me-1 ' + (report.severity === 'high' ? 'bg-danger' : (report.severity === 'medium' ? 'bg-warning' : 'bg-info'));
                        severityBadge.textContent = 'Severity: ' + (report.severity.charAt(0).toUpperCase() + report.severity.slice(1));

                        let statusBadge = document.getElementById('detailStatusBadge');
                        statusBadge.className = 'badge user-select-none ' + (report.status === 'resolved' ? 'bg-success' : 'bg-secondary');
                        statusBadge.textContent = 'Status: ' + (report.status.charAt(0).toUpperCase() + report.status.slice(1));

                        new bootstrap.Modal(document.getElementById('detailModal')).show();
                    }
                });
            });

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