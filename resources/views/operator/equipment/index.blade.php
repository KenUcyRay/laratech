@extends('layouts.app')

@section('title', 'Equipment')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">

        {{-- Header --}}
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
        <ul class="nav nav-tabs mb-4" id="equipTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory-pane"
                    type="button" role="tab">
                    📦 Inventory
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="monitoring-tab" data-bs-toggle="tab"
                    data-bs-target="#monitoring-pane" type="button" role="tab">
                    ⚙️ Monitoring
                </button>
            </li>
        </ul>

        <div class="tab-content" id="equipTabsContent">

            {{-- TAB 1: INVENTORY (All Items, No Report Action) --}}
            <div class="tab-pane fade" id="inventory-pane" role="tabpanel" tabindex="0">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">No</th>
                                        <th class="fw-semibold">Kode</th>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Tipe</th>
                                        <th class="fw-semibold">Status</th>
                                        <th class="fw-semibold">Hour Meter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allEquipments as $index => $equipment)
                                        <tr>
                                            <td class="fw-medium">
                                                {{ ($allEquipments->currentPage() - 1) * $allEquipments->perPage() + $index + 1 }}
                                            </td>
                                            <td class="fw-medium">{{ $equipment->code }}</td>
                                            <td>{{ $equipment->name }}</td>
                                            <td>{{ $equipment->type->name ?? '-' }}</td>
                                            <td>
                                                @if($equipment->status === 'operasi')
                                                    <span class="badge bg-success">Operasi</span>
                                                @elseif($equipment->status === 'servis')
                                                    <span class="badge bg-warning">Servis</span>
                                                @elseif($equipment->status === 'rusak')
                                                    <span class="badge bg-danger">Rusak</span>
                                                @else
                                                    <span class="badge bg-secondary">Idle</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($equipment->hour_meter) }} jam</td>
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
                        {{-- Pagination for Inventory --}}
                        {{ $allEquipments->appends(['monitoring_page' => $monitorEquipments->currentPage()])->links('custom.pagination') }}
                    </div>
                </div>
            </div>

            {{-- TAB 2: MONITORING (Filtered Items, With Buat Laporan) --}}
            <div class="tab-pane fade show active" id="monitoring-pane" role="tabpanel" tabindex="0">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">No</th>
                                        <th class="fw-semibold">Kode</th>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Tipe</th>
                                        <th class="fw-semibold">Status</th>
                                        <th class="fw-semibold">Hour Meter</th>
                                        <th class="fw-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($monitorEquipments as $index => $equipment)
                                        <tr>
                                            <td class="fw-medium">
                                                {{ ($monitorEquipments->currentPage() - 1) * $monitorEquipments->perPage() + $index + 1 }}
                                            </td>
                                            <td class="fw-medium">{{ $equipment->code }}</td>
                                            <td>{{ $equipment->name }}</td>
                                            <td>{{ $equipment->type->name ?? '-' }}</td>
                                            <td>
                                                @if($equipment->status === 'operasi')
                                                    <span class="badge bg-success">Operasi</span>
                                                @elseif($equipment->status === 'servis')
                                                    <span class="badge bg-warning">Servis</span>
                                                @elseif($equipment->status === 'rusak')
                                                    <span class="badge bg-danger">Rusak</span>
                                                @else
                                                    <span class="badge bg-secondary">Idle</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($equipment->hour_meter) }} jam</td>
                                            <td>
                                                {{-- Tombol buat laporan --}}
                                                <button class="btn btn-sm btn-warning btn-report" data-bs-toggle="modal"
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
                                                    <p class="mb-0">Semua equipment termonitor aman (atau sedang dalam
                                                        perbaikan)</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination for Monitoring --}}
                        {{ $monitorEquipments->appends(['inventory_page' => $allEquipments->currentPage()])->links('custom.pagination') }}
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

    {{-- Pastikan Bootstrap JS ada --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const reportModal = document.getElementById('reportModal');
                if (reportModal) {
                    reportModal.addEventListener('show.bs.modal', function (event) {
                        // Button that triggered the modal
                        const button = event.relatedTarget;
                        // Extract info from data-attributes
                        const equipmentId = button.getAttribute('data-equipment-id');

                        // Update the modal's content.
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