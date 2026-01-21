@extends('layouts.app')

@section('title', 'Equipment Inventory')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tools" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Equipment Inventory</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            🚜 Kelola dan monitor status semua equipment
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipment Table --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($equipments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="15%">Code</th>
                                    <th width="25%">Name</th>
                                    <th width="20%">Type</th>
                                    <th width="20%">Current Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipments as $eq)
                                    <tr id="row-{{ $eq->id }}">
                                        <td><span class="badge bg-secondary">{{ $eq->code }}</span></td>
                                        <td><strong>{{ $eq->name }}</strong></td>
                                        <td>{{ $eq->type->name ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $eq->status == 'idle' ? 'secondary' : ($eq->status == 'operasi' ? 'success' : ($eq->status == 'rusak' ? 'danger' : 'warning')) }}">
                                                {{ ucfirst($eq->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning text-white update-status-btn"
                                                data-id="{{ $eq->id }}" data-status="{{ $eq->status }}" data-name="{{ $eq->name }}">
                                                <i class="fas fa-edit"></i> Update
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    @if($equipments->hasPages())
                        <div class="d-flex justify-content-end mt-4">
                            {{ $equipments->links('custom.mekanik-pagination') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Equipment Found</h5>
                        <p class="text-muted">There are currently no equipment items to display.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Status Update Modal --}}
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="statusForm">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 pb-2"
                        style="background: linear-gradient(135deg, #f6c23e 0%, #f4a20c 100%);">
                        <h5 class="modal-title fw-bold text-white">Update Status: <span id="eqName"></span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-3 px-4">
                        <input type="hidden" name="id" id="eqId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">New Status</label>
                            <select name="status" class="form-select form-select-lg" required>
                                <option value="idle">🟡 Idle</option>
                                <option value="operasi">🟢 Operasi</option>
                                <option value="rusak">🔴 Rusak</option>
                                <option value="servis">🟠 Servis</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white fw-bold"
                            style="background: linear-gradient(135deg, #f6c23e 0%, #f4a20c 100%);">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.update-status-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    let name = this.dataset.name;
                    let currentStatus = this.dataset.status;

                    document.getElementById('eqId').value = id;
                    document.getElementById('eqName').innerText = name;
                    document.querySelector(`select[name="status"]`).value = currentStatus;

                    new bootstrap.Modal(document.getElementById('statusModal')).show();
                });
            });

            document.getElementById('statusForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let id = document.getElementById('eqId').value;
                let status = document.querySelector(`select[name="status"]`).value;

                fetch(`/mekanik/inventory/${id}`, {
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