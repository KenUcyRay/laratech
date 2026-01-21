@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">

        {{-- Header --}}
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
                    <button class="btn btn-light rounded-pill px-4 py-3 shadow" data-bs-toggle="modal"
                        data-bs-target="#reportModal">
                        <i class="fas fa-plus me-2"></i>
                        Buat Laporan
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm rounded-4">
            <div class="card-body">

                <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="all-tab" data-bs-toggle="tab"
                            data-bs-target="#all-reports-pane" type="button" role="tab">
                            📋 Semua Laporan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="my-tab" data-bs-toggle="tab" data-bs-target="#my-reports-pane"
                            type="button" role="tab">
                            👤 Laporan Saya
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="reportTabsContent">

                    {{-- TAB 1: SEMUA LAPORAN (NO DELETE BUTTON) --}}
                    <div class="tab-pane fade show active" id="all-reports-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Equipment</th>
                                        <th>Deskripsi</th>
                                        <th>Severity</th>
                                        <th>Status</th>
                                        <th>Pelapor</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allReports as $report)
                                        <tr>
                                            <td>{{ ($allReports->currentPage() - 1) * $allReports->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $report->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $report->equipment->code ?? '-' }}</span>
                                                {{ $report->equipment->name ?? '-' }}
                                            </td>
                                            <td>{{ Str::limit($report->description, 50) }}</td>
                                            <td>
                                                <span class="badge
                                                        @if($report->severity === 'high') bg-danger
                                                        @elseif($report->severity === 'medium') bg-warning
                                                        @else bg-success
                                                        @endif">
                                                    {{ ucfirst($report->severity) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge
                                                        @if($report->status === 'pending') bg-secondary
                                                        @elseif($report->status === 'processing') bg-primary
                                                        @elseif($report->status === 'resolved') bg-success
                                                        @endif">
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $report->user->name ?? '-' }}</td>
                                            <td class="text-center">
                                                {{-- ONLY PDF --}}
                                                <a href="{{ route('operator.reports.pdf', $report->id) }}"
                                                    class="btn btn-sm btn-danger" title="Download PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i
                                                    class="fas fa-clipboard-list fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                                Belum ada laporan masuk
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination for All Reports --}}
                        {{ $allReports->appends(['my_page' => $myReports->currentPage()])->links('custom.pagination') }}
                    </div>

                    {{-- TAB 2: LAPORAN SAYA (WITH DELETE BUTTON) --}}
                    <div class="tab-pane fade" id="my-reports-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Equipment</th>
                                        <th>Deskripsi</th>
                                        <th>Severity</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myReports as $report)
                                        <tr>
                                            <td>{{ ($myReports->currentPage() - 1) * $myReports->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $report->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $report->equipment->code ?? '-' }}</span>
                                                {{ $report->equipment->name ?? '-' }}
                                            </td>
                                            <td>{{ Str::limit($report->description, 50) }}</td>
                                            <td>
                                                <span class="badge
                                                        @if($report->severity === 'high') bg-danger
                                                        @elseif($report->severity === 'medium') bg-warning
                                                        @else bg-success
                                                        @endif">
                                                    {{ ucfirst($report->severity) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge
                                                        @if($report->status === 'pending') bg-secondary
                                                        @elseif($report->status === 'processing') bg-primary
                                                        @elseif($report->status === 'resolved') bg-success
                                                        @endif">
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    {{-- PDF --}}
                                                    <a href="{{ route('operator.reports.pdf', $report->id) }}"
                                                        class="btn btn-sm btn-danger" title="Download PDF">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>

                                                    {{-- DELETE (Only if pending) --}}
                                                    @if($report->status === 'pending')
                                                        <form action="{{ route('operator.reports.destroy', $report->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Hapus Laporan">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-folder-open fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                                Anda belum membuat laporan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination for My Reports --}}
                        {{ $myReports->appends(['all_page' => $allReports->currentPage()])->links('custom.pagination') }}
                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- MODAL CREATE REPORT --}}
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title">🚨 Laporan Kerusakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('operator.reports.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <select name="equipment_id" class="form-select" required>
                                <option value="">Pilih equipment</option>
                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->id }}">
                                        {{ $equipment->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Equipment</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control" style="height:120px" required></textarea>
                            <label>Deskripsi Kerusakan</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="severity" class="form-select" required>
                                <option value="">Pilih severity</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            <label>Severity</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Kerusakan</label>
                            <input type="file" name="photos[]" class="form-control" multiple>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Kirim Laporan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection