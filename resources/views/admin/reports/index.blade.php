@extends('layouts.app')

@section('title', 'Reports')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
        style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-chart-bar" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Reports Management</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        📈 Monitor dan kelola laporan sistem
                    </p>
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light btn-lg rounded-3 shadow-sm me-2">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <button type="button" class="btn btn-light btn-lg rounded-3 shadow-sm">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100"
                style="background: linear-gradient(145deg, #3b82f6 0%, #1d4ed8 100%); transform: translateY(0); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-clipboard-list fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['total'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Reports</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100"
                style="background: linear-gradient(145deg, #ef4444 0%, #dc2626 100%); transform: translateY(0); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['high_priority'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">High Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100"
                style="background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); transform: translateY(0); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-circle fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['medium_priority'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Medium Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100"
                style="background: linear-gradient(145deg, #10b981 0%, #059669 100%); transform: translateY(0); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-info-circle fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['low_priority'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Low Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100"
                style="background: linear-gradient(145deg, #10b981 0%, #059669 100%); transform: translateY(0); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['resolved'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Resolved</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100"
                style="background: linear-gradient(145deg, #6b7280 0%, #4b5563 100%); transform: translateY(0); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-clock fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['pending'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Pending</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card border-0 shadow-lg rounded-4"
        style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">📈 Recent Reports</h5>
                <span class="badge bg-primary rounded-pill fs-6">{{ $reports->total() }} reports</span>
            </div>
        </div>
        <div class="card-body p-4">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold border-0 py-3">ID</th>
                                <th class="fw-semibold border-0 py-3">Title</th>
                                <th class="fw-semibold border-0 py-3">Equipment</th>
                                <th class="fw-semibold border-0 py-3">Reporter</th>
                                <th class="fw-semibold border-0 py-3">Severity</th>
                                <th class="fw-semibold border-0 py-3">Status</th>
                                <th class="fw-semibold border-0 py-3">Created</th>
                                <th class="fw-semibold border-0 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr class="border-0">
                                    <td class="fw-medium py-3">{{ $report->id }}</td>
                                    <td class="fw-medium py-3">{{ $report->title ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $report->equipment->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $report->reporter->name ?? 'N/A' }}</td>
                                    <td class="py-3">
                                        @if($report->severity === 'high')
                                            <span class="badge bg-danger rounded-pill px-3 py-2">High</span>
                                        @elseif($report->severity === 'medium')
                                            <span class="badge bg-warning rounded-pill px-3 py-2">Medium</span>
                                        @else
                                            <span class="badge bg-success rounded-pill px-3 py-2">Low</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($report->status === 'resolved')
                                            <span class="badge bg-success rounded-pill px-3 py-2">Resolved</span>
                                        @elseif($report->status === 'in_progress')
                                            <span class="badge bg-warning rounded-pill px-3 py-2">In Progress</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">Open</span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ $report->created_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-sm btn-info rounded-start">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#updateStatusModal" data-report-id="{{ $report->id }}"
                                                data-report-title="{{ $report->title }}"
                                                data-report-status="{{ $report->status }}"
                                                onclick="populateStatusForm(this)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                                data-bs-target="#deleteReportModal"
                                                onclick="setDeleteForm('{{ $report->id }}', '{{ addslashes($report->title ?? 'Report #' . $report->id) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if ($reports->onFirstPage())
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @else
                            <a href="{{ $reports->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        @endif

                        <span class="text-muted small mx-2">
                            Page {{ $reports->currentPage() }} of {{ $reports->lastPage() }}
                        </span>

                        @if ($reports->hasMorePages())
                            <a href="{{ $reports->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-chart-bar fs-3 mb-2"></i>
                        <h5 class="mb-2">No Reports Found</h5>
                        <p class="mb-0">Reports will appear here when data is available.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Update Report Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="updateStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Report</label>
                        <input type="text" class="form-control rounded-3 border-2" id="reportTitle" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-control rounded-3 border-2" name="status" id="reportStatus" required>
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Report Modal -->
<div class="modal fade" id="deleteReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Report</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold mb-2">Are you sure?</h6>
                <p class="text-muted mb-0">You are about to delete the report: <strong id="deleteReportTitle"></strong></p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center">
                <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST" id="deleteReportForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3">
                        <i class="fas fa-trash me-2"></i>Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function populateStatusForm(button) {
        const id = button.getAttribute('data-report-id');
        const title = button.getAttribute('data-report-title');
        const status = button.getAttribute('data-report-status');

        document.getElementById('updateStatusForm').action = `/admin/reports/${id}`;
        document.getElementById('reportTitle').value = title || `Report #${id}`;
        document.getElementById('reportStatus').value = status || 'open';
    }

    function setDeleteForm(id, title) {
        document.getElementById('deleteReportForm').action = `/admin/reports/${id}`;
        document.getElementById('deleteReportTitle').textContent = title;
    }
</script>
@endpush