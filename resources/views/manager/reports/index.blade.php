@extends('layouts.app')

@section('title', 'Reports')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@push('styles')
<style>
.btn-outline-primary {
    color: #374151;
    border-color: #374151;
    background: transparent;
}
.btn-outline-primary:hover {
    color: #ffffff;
    background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
    border-color: #4b5563;
    box-shadow: 0 2px 4px rgba(75, 85, 99, 0.3);
}
</style>
@endpush

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-chart-area" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Reports</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        📈 Analisis laporan dan monitoring sistem
                    </p>
                </div>
                <div>
                    <a href="{{ route('manager.reports.export.pdf') }}" class="btn btn-light btn-lg rounded-3 shadow-sm">
                        <i class="fas fa-download me-2"></i>Export to PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #3b82f6 0%, #1d4ed8 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-file-alt fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['total'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Reports</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #ef4444 0%, #dc2626 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['high'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">High Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['medium'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Medium Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #06b6d4 0%, #0891b2 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-info fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['low'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Low Priority</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">📄 All Reports</h5>
                <span class="badge bg-primary rounded-pill fs-6">{{ $reports->count() }} reports</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 py-3">Equipment</th>
                            <th class="fw-semibold border-0 py-3">Reporter</th>
                            <th class="fw-semibold border-0 py-3">Description</th>
                            <th class="fw-semibold border-0 py-3">Severity</th>
                            <th class="fw-semibold border-0 py-3">Status</th>
                            <th class="fw-semibold border-0 py-3">Date</th>
                            <th class="fw-semibold border-0 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr class="border-0">
                            <td class="fw-medium py-3">{{ $report->equipment->name ?? 'N/A' }}</td>
                            <td class="py-3">{{ $report->reporter->name ?? 'N/A' }}</td>
                            <td class="py-3">{{ Str::limit($report->description, 50) }}</td>
                            <td class="py-3">
                                @if($report->severity == 'high')
                                    <span class="badge bg-danger rounded-pill px-3 py-2">High</span>
                                @elseif($report->severity == 'medium')
                                    <span class="badge bg-warning rounded-pill px-3 py-2">Medium</span>
                                @else
                                    <span class="badge bg-info rounded-pill px-3 py-2">Low</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-secondary rounded-pill px-3 py-2">{{ ucfirst($report->status) }}</span>
                            </td>
                            <td class="py-3">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-3">
                                <button class="btn btn-sm btn-info rounded-3" data-bs-toggle="modal" data-bs-target="#viewModal" 
                                    data-report-id="{{ $report->id }}"
                                    data-report-equipment="{{ $report->equipment->name ?? 'N/A' }}"
                                    data-report-reporter="{{ $report->reporter->name ?? 'N/A' }}"
                                    data-report-description="{{ $report->description }}"
                                    data-report-severity="{{ $report->severity }}"
                                    data-report-status="{{ $report->status }}"
                                    data-report-date="{{ $report->created_at->format('Y-m-d H:i') }}"
                                    onclick="populateViewModal(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $reports->firstItem() ?? 1 }} to {{ $reports->lastItem() ?? $reports->count() }} of {{ $reports->total() }} results
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
        </div>
    </div>

</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-eye me-2"></i>Report Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Equipment:</td>
                                <td id="viewEquipment"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Reporter:</td>
                                <td id="viewReporter"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Severity:</td>
                                <td><span id="viewSeverity" class="badge"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Status:</td>
                                <td><span id="viewStatus" class="badge bg-secondary"></span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Date:</td>
                                <td id="viewDate"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="fw-semibold">Description:</label>
                    <div class="bg-light p-3 rounded-3 mt-2">
                        <p id="viewDescription" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function populateViewModal(button) {
    document.getElementById('viewEquipment').textContent = button.dataset.reportEquipment;
    document.getElementById('viewReporter').textContent = button.dataset.reportReporter;
    document.getElementById('viewDescription').textContent = button.dataset.reportDescription;
    document.getElementById('viewDate').textContent = button.dataset.reportDate;
    
    const severityBadge = document.getElementById('viewSeverity');
    const severity = button.dataset.reportSeverity;
    severityBadge.textContent = severity.charAt(0).toUpperCase() + severity.slice(1);
    severityBadge.className = 'badge ' + (severity === 'high' ? 'bg-danger' : (severity === 'medium' ? 'bg-warning' : 'bg-info'));
    
    const statusBadge = document.getElementById('viewStatus');
    const status = button.dataset.reportStatus;
    statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
}
</script>
@endpush
@endsection