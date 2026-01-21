@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('sidebar')
    @include('components.operator-sidebar')
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
            style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-exclamation-triangle"
                    style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold mb-0 text-white">Laporan Kerusakan</h1>
                        <p class="text-white-50 mb-0 fs-6">
                            🚨 Laporkan kerusakan equipment dengan detail dan foto
                        </p>
                    </div>
                    <button class="btn btn-light btn-lg rounded-3 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#reportModal">
                        <i class="fas fa-plus me-2"></i>
                        Buat Laporan
                    </button>
                </div>
            </div>
        </div>

        {{-- Reports Table --}}
        <div class="card border-0 shadow-lg rounded-4"
            style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
            <div class="card-header bg-transparent border-0 p-4">
                <ul class="nav nav-tabs border-0" id="reportTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold border-0 rounded-3 me-2" id="all-tab" data-bs-toggle="tab"
                            data-bs-target="#all-reports-pane" type="button" role="tab">
                            📋 Semua Laporan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold border-0 rounded-3" id="my-tab" data-bs-toggle="tab" data-bs-target="#my-reports-pane"
                            type="button" role="tab">
                            👤 Laporan Saya
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="reportTabsContent">

                    {{-- TAB 1: SEMUA LAPORAN --}}
                    <div class="tab-pane fade show active" id="all-reports-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold border-0 py-3">No</th>
                                        <th class="fw-semibold border-0 py-3">Tanggal</th>
                                        <th class="fw-semibold border-0 py-3">Equipment</th>
                                        <th class="fw-semibold border-0 py-3">Deskripsi</th>
                                        <th class="fw-semibold border-0 py-3">Severity</th>
                                        <th class="fw-semibold border-0 py-3">Status</th>
                                        <th class="fw-semibold border-0 py-3">Pelapor</th>
                                        <th class="fw-semibold border-0 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allReports as $report)
                                        <tr class="border-0">
                                            <td class="fw-medium py-3">{{ ($allReports->currentPage() - 1) * $allReports->perPage() + $loop->iteration }}</td>
                                            <td class="py-3">{{ $report->created_at->format('d-m-Y') }}</td>
                                            <td class="py-3">
                                                <span class="badge bg-secondary rounded-pill px-2 py-1 me-2">{{ $report->equipment->code ?? '-' }}</span>
                                                {{ $report->equipment->name ?? '-' }}
                                            </td>
                                            <td class="py-3">{{ Str::limit($report->description, 50) }}</td>
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
                                                @if($report->status === 'pending')
                                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Pending</span>
                                                @elseif($report->status === 'processing')
                                                    <span class="badge bg-primary rounded-pill px-3 py-2">Processing</span>
                                                @elseif($report->status === 'resolved')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Resolved</span>
                                                @endif
                                            </td>
                                            <td class="py-3">{{ $report->user->name ?? '-' }}</td>
                                            <td class="py-3 text-center">
                                                <a href="{{ route('operator.reports.pdf', $report->id) }}"
                                                    class="btn btn-sm btn-danger rounded-3" title="Download PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-clipboard-list fs-3 mb-2"></i>
                                                    <p class="mb-0">Belum ada laporan masuk</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                                Showing {{ $allReports->firstItem() }} to {{ $allReports->lastItem() }} of {{ $allReports->total() }} results
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if ($allReports->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                @else
                                    <a href="{{ $allReports->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                @endif

                                <span class="text-muted small mx-2">
                                    Page {{ $allReports->currentPage() }} of {{ $allReports->lastPage() }}
                                </span>

                                @if ($allReports->hasMorePages())
                                    <a href="{{ $allReports->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

                    {{-- TAB 2: LAPORAN SAYA --}}
                    <div class="tab-pane fade" id="my-reports-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold border-0 py-3">No</th>
                                        <th class="fw-semibold border-0 py-3">Tanggal</th>
                                        <th class="fw-semibold border-0 py-3">Equipment</th>
                                        <th class="fw-semibold border-0 py-3">Deskripsi</th>
                                        <th class="fw-semibold border-0 py-3">Severity</th>
                                        <th class="fw-semibold border-0 py-3">Status</th>
                                        <th class="fw-semibold border-0 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myReports as $report)
                                        <tr class="border-0">
                                            <td class="fw-medium py-3">{{ ($myReports->currentPage() - 1) * $myReports->perPage() + $loop->iteration }}</td>
                                            <td class="py-3">{{ $report->created_at->format('d-m-Y') }}</td>
                                            <td class="py-3">
                                                <span class="badge bg-secondary rounded-pill px-2 py-1 me-2">{{ $report->equipment->code ?? '-' }}</span>
                                                {{ $report->equipment->name ?? '-' }}
                                            </td>
                                            <td class="py-3">{{ Str::limit($report->description, 50) }}</td>
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
                                                @if($report->status === 'pending')
                                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Pending</span>
                                                @elseif($report->status === 'processing')
                                                    <span class="badge bg-primary rounded-pill px-3 py-2">Processing</span>
                                                @elseif($report->status === 'resolved')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Resolved</span>
                                                @endif
                                            </td>
                                            <td class="py-3 text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('operator.reports.pdf', $report->id) }}"
                                                        class="btn btn-sm btn-danger rounded-start" title="Download PDF">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    @if($report->status === 'pending')
                                                        <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                                            data-bs-target="#deleteReportModal"
                                                            onclick="setDeleteForm('{{ $report->id }}', '{{ addslashes($report->description) }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-folder-open fs-3 mb-2"></i>
                                                    <p class="mb-0">Anda belum membuat laporan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                                Showing {{ $myReports->firstItem() }} to {{ $myReports->lastItem() }} of {{ $myReports->total() }} results
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if ($myReports->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                @else
                                    <a href="{{ $myReports->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                @endif

                                <span class="text-muted small mx-2">
                                    Page {{ $myReports->currentPage() }} of {{ $myReports->lastPage() }}
                                </span>

                                @if ($myReports->hasMorePages())
                                    <a href="{{ $myReports->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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
        </div>

    </div>

    {{-- MODAL CREATE REPORT --}}
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Buat Laporan Kerusakan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('operator.reports.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Equipment</label>
                                <select name="equipment_id" class="form-control rounded-3 border-2" required>
                                    <option value="">Pilih equipment</option>
                                    @foreach($equipments as $equipment)
                                        <option value="{{ $equipment->id }}">
                                            {{ $equipment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi Kerusakan</label>
                                <textarea name="description" class="form-control rounded-3 border-2" rows="4" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Severity</label>
                                <select name="severity" class="form-control rounded-3 border-2" required>
                                    <option value="">Pilih severity</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Foto Kerusakan</label>
                                <input type="file" name="photos[]" class="form-control rounded-3 border-2" multiple>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Kirim Laporan</button>
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
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Hapus Laporan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Yakin ingin menghapus?</h6>
                    <p class="text-muted mb-0">Laporan: <strong id="deleteReportDesc"></strong></p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer border-0 p-4 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Batal</button>
                    <form action="" method="POST" id="deleteReportForm" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3">
                            <i class="fas fa-trash me-2"></i>Hapus Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function setDeleteForm(id, description) {
        document.getElementById('deleteReportForm').action = `/operator/reports/${id}`;
        document.getElementById('deleteReportDesc').textContent = description.substring(0, 50) + '...';
    }
</script>
@endpush