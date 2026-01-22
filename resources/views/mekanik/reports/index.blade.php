@extends('layouts.app')

@section('title', 'Laporan & Issues')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
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

        {{-- Tabs & Filters --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <ul class="nav nav-pills custom-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab', 'pending') == 'pending' ? 'active' : '' }} fw-bold"
                        href="{{ route('mekanik.reports.index', ['tab' => 'pending']) }}"
                        style="border-radius: 50px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-clock me-2"></i>Pending Reports
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link {{ request('tab') == 'my_processing' ? 'active' : '' }} fw-bold"
                        href="{{ route('mekanik.reports.index', ['tab' => 'my_processing']) }}"
                        style="border-radius: 50px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-spinner me-2"></i>My Processing
                    </a>
                </li>
            </ul>

            <div class="d-flex">
                <a href="{{ route('mekanik.reports.index', ['tab' => request('tab', 'pending'), 'severity' => 'high']) }}"
                    class="btn btn-sm {{ request('severity') == 'high' ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-3">
                    <i class="fas fa-exclamation-circle me-1"></i> High Priority
                </a>
            </div>
        </div>

        <style>
            .custom-tabs .nav-link {
                color: #6c757d;
                background-color: white;
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
            }

            .custom-tabs .nav-link:hover {
                background-color: #f8f9fa;
                transform: translateY(-2px);
            }

            .custom-tabs .nav-link.active {
                background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);
                color: white !important;
                border: none;
                box-shadow: 0 4px 6px rgba(182, 119, 29, 0.3);
            }
        </style>

        {{-- Reports Table --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="fw-semibold" width="10%">Date</th>
                                    <th class="fw-semibold" width="15%">Equipment</th>
                                    <th class="fw-semibold" width="12%">Reporter</th>
                                    @if(request('tab') == 'my_processing')
                                        <th class="fw-semibold" width="12%">Processed By</th>
                                    @endif
                                    <th class="fw-semibold" width="20%">Description</th>
                                    <th class="fw-semibold" width="10%">Severity</th>
                                    <th class="fw-semibold" width="10%">Status</th>
                                    <th class="fw-semibold" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr id="row-{{ $report->id }}">
                                        <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $report->equipment->name ?? '-' }}</td>
                                        <td>{{ $report->reporter->name ?? '-' }}</td>
                                        @if(request('tab') == 'my_processing')
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <i class="fas fa-user-cog me-1"></i> {{ $report->processor->name ?? 'Me' }}
                                                </span>
                                            </td>
                                        @endif
                                        <td><small>{{ Str::limit($report->description, 35) }}</small></td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $report->severity == 'high' ? 'danger' : ($report->severity == 'medium' ? 'warning' : 'info') }}">
                                                {{ ucfirst($report->severity) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($report->status == 'resolved')
                                                <span class="badge bg-success">Resolved</span>
                                            @elseif($report->status == 'processing')
                                                <span class="badge bg-primary">Processing</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
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
                                                    <a href="{{ route('mekanik.tasks.index') }}" class="btn btn-sm btn-secondary"
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
                    {{ $reports->links('custom.mekanik-pagination') }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-4 opacity-50"></i>
                        <h5 class="text-muted fw-semibold">No Reports Found</h5>
                        <p class="text-muted mb-0">There are currently no issue reports to display.</p>
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
                    <div class="modal-header border-0"
                        style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
                        <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Update Report Status</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="reportId">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-uppercase small text-muted"
                                style="letter-spacing: 0.5px;">Status</label>
                            <select id="reportStatus" class="form-select form-select-lg">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white fw-bold"
                            style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);"><i
                                class="fas fa-save me-1"></i>Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
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
                                            <div class="text-uppercase small fw-semibold text-info mb-2"
                                                style="letter-spacing: 0.5px;">
                                                Equipment
                                            </div>
                                            <div class="h5 mb-0 fw-bold text-gray-800" id="detailEquipmentName">-
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
                                            <div class="text-uppercase small fw-semibold text-warning mb-2"
                                                style="letter-spacing: 0.5px;">
                                                Reported
                                                By</div>
                                            <div class="h5 mb-0 fw-bold text-gray-800" id="detailReporterName">
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
                            <h6 class="m-0 fw-semibold text-secondary">Description</h6>
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