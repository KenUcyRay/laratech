@extends('layouts.app')

@section('title', 'Equipment Inventory')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-tools" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Equipment Management</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        ⚙️ Kelola inventaris dan status equipment
                    </p>
                </div>
                <button class="btn btn-light rounded-pill px-4 py-3 shadow" data-bs-toggle="modal" data-bs-target="#createModal" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-plus me-2 text-primary"></i>
                    <span class="fw-semibold text-dark">Add Equipment</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Equipment Table --}}
    <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Image</th>
                            <th class="fw-semibold">Code</th>
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Type</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Hour Meter</th>
                            <th class="fw-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $eq)
                            <tr id="row-{{ $eq->id }}">
                                <td>
                                    @if($eq->images->count() > 0)
                                        <img src="{{ $eq->images->first()->image_url }}" alt="img" width="50" class="rounded-3">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-medium">{{ $eq->code }}</td>
                                <td class="fw-medium">{{ $eq->name }}</td>
                                <td>{{ $eq->type->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $eq->status == 'idle' ? 'secondary' : ($eq->status == 'operasi' ? 'success' : ($eq->status == 'rusak' ? 'danger' : 'warning')) }} rounded-pill">
                                        {{ ucfirst($eq->status) }}
                                    </span>
                                </td>
                                <td>{{ $eq->hour_meter }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info rounded-pill me-1 view-btn" data-id="{{ $eq->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning rounded-pill me-1 edit-btn" data-id="{{ $eq->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger rounded-pill delete-btn" data-id="{{ $eq->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="createForm" enctype="multipart/form-data">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div class="text-center w-100">
                        <h3 class="fw-bold text-dark mb-2" style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Add Equipment</h3>
                        <p class="text-muted mb-0 fs-6">Tambah equipment baru ke inventaris</p>
                    </div>
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top: 15px; right: 15px;"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" name="code" class="form-control border-0 shadow-sm" required style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                            <label class="text-muted">Code</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" name="name" class="form-control border-0 shadow-sm" required style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                            <label class="text-muted">Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select name="equipment_type_id" class="form-select border-0 shadow-sm" required style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <label class="text-muted">Type</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select name="status" class="form-select border-0 shadow-sm" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                                <option value="idle">Idle</option>
                                <option value="operasi">Operasi</option>
                                <option value="rusak">Rusak</option>
                                <option value="servis">Servis</option>
                            </select>
                            <label class="text-muted">Status</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="number" name="hour_meter" class="form-control border-0 shadow-sm" min="0" value="0" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                            <label class="text-muted">Hour Meter</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Images</label>
                        <input type="file" name="images[]" class="form-control border-0 shadow-sm" multiple accept="image/*" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2 me-2" data-bs-dismiss="modal" style="background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%); border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow" style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%); border: none; box-shadow: 0 4px 15px rgba(30, 64, 175, 0.4);">
                        <i class="fas fa-save me-2"></i>Save Equipment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('createForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch("{{ route('admin.equipment.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert('Error: ' + JSON.stringify(data));
                    }
                });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Delete equipment?')) return;
                let id = this.dataset.id;
                fetch(`/admin/equipment/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') document.getElementById(`row-${id}`).remove();
                    });
            });
        });
    </script>
@endpush
@endsection