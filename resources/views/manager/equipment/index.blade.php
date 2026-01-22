@extends('layouts.app')

@section('title', 'Equipment Management')

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

        .border-left-primary {
            border-left: 0.25rem solid #7c3aed !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
    </style>
@endpush

@section('content')
    <div class="position-relative overflow-hidden rounded-4 shadow-lg my-4"
        style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
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
                        🚜 Manage and monitor all equipment inventory
                    </p>
                </div>
                <div>
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-2"></i>Add Equipment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-transparent border-0 p-4">
            <h5 class="mb-0 fw-bold">📦 Equipment Inventory</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
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
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $eq->code }}</td>
                                <td>{{ $eq->name }}</td>
                                <td>{{ $eq->type->name ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $eq->status == 'idle' ? 'secondary' : ($eq->status == 'operasi' ? 'success' : ($eq->status == 'rusak' ? 'danger' : 'warning')) }}">
                                        {{ ucfirst($eq->status) }}
                                    </span>
                                </td>
                                <td>{{ $eq->hour_meter }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-info rounded-start" data-bs-toggle="modal"
                                            data-bs-target="#viewModal" data-equipment-id="{{ $eq->id }}"
                                            data-equipment-code="{{ $eq->code }}" data-equipment-name="{{ $eq->name }}"
                                            data-equipment-type="{{ $eq->type->name ?? '-' }}"
                                            data-equipment-status="{{ $eq->status }}"
                                            data-equipment-hour="{{ $eq->hour_meter }}"
                                            data-equipment-image="{{ $eq->images->count() > 0 ? $eq->images->first()->image_url : '' }}"
                                            onclick="populateViewModal(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-equipment-id="{{ $eq->id }}"
                                            data-equipment-code="{{ $eq->code }}" data-equipment-name="{{ $eq->name }}"
                                            data-equipment-type-id="{{ $eq->equipment_type_id }}"
                                            data-equipment-status="{{ $eq->status }}"
                                            data-equipment-hour="{{ $eq->hour_meter }}" onclick="populateEditForm(this)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $eq->id }}" data-name="{{ $eq->name }}"
                                            onclick="setDeleteForm(this)">
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
                    Showing {{ $equipments->firstItem() ?? 1 }} to {{ $equipments->lastItem() ?? $equipments->count() }} of
                    {{ $equipments->total() }} results
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($equipments->onFirstPage())
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $equipments->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif

                    <span class="text-muted small mx-2">
                        Page {{ $equipments->currentPage() }} of {{ $equipments->lastPage() }}
                    </span>

                    @if ($equipments->hasMorePages())
                        <a href="{{ $equipments->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Add Equipment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.equipment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Code</label>
                                    <input type="text" name="code" class="form-control rounded-3 border-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name</label>
                                    <input type="text" name="name" class="form-control rounded-3 border-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Type</label>
                                    <select name="equipment_type_id" class="form-select rounded-3 border-2" required>
                                        <option value="">Select Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select name="status" class="form-select rounded-3 border-2">
                                        <option value="idle">Idle</option>
                                        <option value="operasi">Operasi</option>
                                        <option value="rusak">Rusak</option>
                                        <option value="servis">Servis</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hour Meter</label>
                            <input type="number" name="hour_meter" class="form-control rounded-3 border-2" min="0"
                                value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Images</label>
                            <input type="file" name="images[]" class="form-control rounded-3 border-2" multiple
                                accept="image/*">
                            <div class="form-text">You can select multiple images</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Save
                            Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-eye me-2"></i>Equipment Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img id="viewImage" src="" alt="Equipment Image" class="img-fluid rounded-3"
                                    style="max-height: 200px; display: none;">
                                <div id="viewNoImage" class="bg-light rounded-3 align-items-center justify-content-center"
                                    style="height: 200px; display: none;">
                                    <i class="fas fa-image text-muted fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold">Code:</td>
                                    <td id="viewCode"></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Name:</td>
                                    <td id="viewName"></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Type:</td>
                                    <td id="viewType"></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td><span id="viewStatus" class="badge"></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Hour Meter:</td>
                                    <td id="viewHour"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Equipment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Code</label>
                                    <input type="text" name="code" id="editCode" class="form-control rounded-3 border-2"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name</label>
                                    <input type="text" name="name" id="editName" class="form-control rounded-3 border-2"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Type</label>
                                    <select name="equipment_type_id" id="editType" class="form-select rounded-3 border-2"
                                        required>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select name="status" id="editStatus" class="form-select rounded-3 border-2">
                                        <option value="idle">Idle</option>
                                        <option value="operasi">Operasi</option>
                                        <option value="rusak">Rusak</option>
                                        <option value="servis">Servis</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hour Meter</label>
                            <input type="number" name="hour_meter" id="editHour" class="form-control rounded-3 border-2"
                                min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Add New Images</label>
                            <input type="file" name="images[]" class="form-control rounded-3 border-2" multiple
                                accept="image/*">
                            <div class="form-text">Leave empty to keep existing images</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update
                            Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Equipment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Are you sure?</h6>
                    <p class="text-muted mb-0">You are about to delete: <strong id="deleteEquipmentName"></strong></p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 p-4 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteForm" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3"><i
                                class="fas fa-trash me-2"></i>Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function populateViewModal(button) {
            document.getElementById('viewCode').textContent = button.dataset.equipmentCode;
            document.getElementById('viewName').textContent = button.dataset.equipmentName;
            document.getElementById('viewType').textContent = button.dataset.equipmentType;
            document.getElementById('viewHour').textContent = button.dataset.equipmentHour;

            const statusBadge = document.getElementById('viewStatus');
            const status = button.dataset.equipmentStatus;
            statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            statusBadge.className = 'badge bg-' + (status === 'idle' ? 'secondary' : (status === 'operasi' ? 'success' : (status === 'rusak' ? 'danger' : 'warning')));

            const imageUrl = button.dataset.equipmentImage;
            if (imageUrl) {
                document.getElementById('viewImage').src = imageUrl;
                document.getElementById('viewNoImage').style.display = 'none';
                document.getElementById('viewImage').style.display = 'block';
            } else {
                document.getElementById('viewImage').style.display = 'none';
                document.getElementById('viewNoImage').style.display = 'flex';
            }
        }

        function populateEditForm(button) {
            const id = button.dataset.equipmentId;
            document.getElementById('editForm').action = `/manager/equipment/${id}`;
            document.getElementById('editCode').value = button.dataset.equipmentCode;
            document.getElementById('editName').value = button.dataset.equipmentName;
            document.getElementById('editType').value = button.dataset.equipmentTypeId;
            document.getElementById('editStatus').value = button.dataset.equipmentStatus;
            document.getElementById('editHour').value = button.dataset.equipmentHour;
        }

        function setDeleteForm(button) {
            const id = button.dataset.id;
            const name = button.dataset.name;
            document.getElementById('deleteForm').action = `/manager/equipment/${id}`;
            document.getElementById('deleteEquipmentName').textContent = name;
        }
    </script>
@endpush