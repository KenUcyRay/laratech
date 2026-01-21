@extends('layouts.app')

@section('title', 'Equipment')

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
                <i class="fas fa-cogs" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Equipment Monitoring</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            ⚙️ Monitoring pemakaian dan status equipment
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipment Table --}}
        <div class="card border-0 shadow-lg rounded-4"
            style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
            <div class="card-header bg-transparent border-0 p-4">
                <ul class="nav nav-tabs border-0" id="equipTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold border-0 rounded-3 me-2" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory-pane"
                            type="button" role="tab">
                            📦 Inventory
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold border-0 rounded-3" id="monitoring-tab" data-bs-toggle="tab"
                            data-bs-target="#monitoring-pane" type="button" role="tab">
                            ⚙️ Monitoring
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="equipTabsContent">

                    {{-- TAB 1: INVENTORY --}}
                    <div class="tab-pane fade" id="inventory-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold border-0 py-3">No</th>
                                        <th class="fw-semibold border-0 py-3">Kode</th>
                                        <th class="fw-semibold border-0 py-3">Equipment</th>
                                        <th class="fw-semibold border-0 py-3">Tipe</th>
                                        <th class="fw-semibold border-0 py-3">Status</th>
                                        <th class="fw-semibold border-0 py-3">Hour Meter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allEquipments as $index => $equipment)
                                        <tr class="border-0">
                                            <td class="fw-medium py-3">
                                                {{ ($allEquipments->currentPage() - 1) * $allEquipments->perPage() + $index + 1 }}
                                            </td>
                                            <td class="fw-medium py-3">{{ $equipment->code }}</td>
                                            <td class="py-3">{{ $equipment->name }}</td>
                                            <td class="py-3">{{ $equipment->type->name ?? '-' }}</td>
                                            <td class="py-3">
                                                @if($equipment->status === 'operasi')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Operasi</span>
                                                @elseif($equipment->status === 'servis')
                                                    <span class="badge bg-warning rounded-pill px-3 py-2">Servis</span>
                                                @elseif($equipment->status === 'rusak')
                                                    <span class="badge bg-danger rounded-pill px-3 py-2">Rusak</span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Idle</span>
                                                @endif
                                            </td>
                                            <td class="py-3">{{ number_format($equipment->hour_meter) }} jam</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-boxes fs-3 mb-2"></i>
                                                    <p class="mb-0">Tidak ada equipment dalam inventory</p>
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
                                Showing {{ $allEquipments->firstItem() }} to {{ $allEquipments->lastItem() }} of {{ $allEquipments->total() }} results
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if ($allEquipments->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                @else
                                    <a href="{{ $allEquipments->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                @endif

                                <span class="text-muted small mx-2">
                                    Page {{ $allEquipments->currentPage() }} of {{ $allEquipments->lastPage() }}
                                </span>

                                @if ($allEquipments->hasMorePages())
                                    <a href="{{ $allEquipments->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

                    {{-- TAB 2: MONITORING --}}
                    <div class="tab-pane fade show active" id="monitoring-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold border-0 py-3">No</th>
                                        <th class="fw-semibold border-0 py-3">Kode</th>
                                        <th class="fw-semibold border-0 py-3">Equipment</th>
                                        <th class="fw-semibold border-0 py-3">Tipe</th>
                                        <th class="fw-semibold border-0 py-3">Status</th>
                                        <th class="fw-semibold border-0 py-3">Hour Meter</th>
                                        <th class="fw-semibold border-0 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($monitorEquipments as $index => $equipment)
                                        <tr class="border-0">
                                            <td class="fw-medium py-3">
                                                {{ ($monitorEquipments->currentPage() - 1) * $monitorEquipments->perPage() + $index + 1 }}
                                            </td>
                                            <td class="fw-medium py-3">{{ $equipment->code }}</td>
                                            <td class="py-3">{{ $equipment->name }}</td>
                                            <td class="py-3">{{ $equipment->type->name ?? '-' }}</td>
                                            <td class="py-3">
                                                @if($equipment->status === 'operasi')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Operasi</span>
                                                @elseif($equipment->status === 'servis')
                                                    <span class="badge bg-warning rounded-pill px-3 py-2">Servis</span>
                                                @elseif($equipment->status === 'rusak')
                                                    <span class="badge bg-danger rounded-pill px-3 py-2">Rusak</span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Idle</span>
                                                @endif
                                            </td>
                                            <td class="py-3">{{ number_format($equipment->hour_meter) }} jam</td>
                                            <td class="py-3">
                                                <button class="btn btn-sm btn-warning rounded-3" data-bs-toggle="modal"
                                                    data-bs-target="#reportModal" data-equipment-id="{{ $equipment->id }}">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Buat Laporan
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-check-circle fs-3 mb-2"></i>
                                                    <p class="mb-0">Semua equipment termonitor aman</p>
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
                                Showing {{ $monitorEquipments->firstItem() }} to {{ $monitorEquipments->lastItem() }} of {{ $monitorEquipments->total() }} results
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if ($monitorEquipments->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                @else
                                    <a href="{{ $monitorEquipments->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                @endif

                                <span class="text-muted small mx-2">
                                    Page {{ $monitorEquipments->currentPage() }} of {{ $monitorEquipments->lastPage() }}
                                </span>

                                @if ($monitorEquipments->hasMorePages())
                                    <a href="{{ $monitorEquipments->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const reportModal = document.getElementById('reportModal');
                if (reportModal) {
                    reportModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const equipmentId = button.getAttribute('data-equipment-id');
                        const select = reportModal.querySelector('select[name="equipment_id"]');
                        if (select && equipmentId) {
                            select.value = equipmentId;
                        }
                    });
                }
            });
        </script>
    @endpush

@endsection