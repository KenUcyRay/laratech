@extends('layouts.app')

@section('title', 'Equipment Types')

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
    </style>
@endpush

@section('content')
    <div class="position-relative overflow-hidden rounded-4 shadow-lg my-4"
        style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-tags" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Equipment Types</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🏷️ Manage and organize equipment categories
                    </p>
                </div>
                <div>
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-2"></i>Add New Type
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-transparent border-0 p-4">
            <h5 class="mb-0 fw-bold">📋 Equipment Types Management</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Description</th>
                            <th class="fw-semibold">Associated Equipments</th>
                            <th class="fw-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $type)
                            <tr id="row-{{ $type->id }}">
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->description }}</td>
                                <td>{{ $type->equipments_count }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning rounded-start" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-type-id="{{ $type->id }}"
                                            data-type-name="{{ $type->name }}" data-type-description="{{ $type->description }}"
                                            onclick="populateEditForm(this)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $type->id }}"
                                            data-name="{{ $type->name }}" data-count="{{ $type->equipments_count }}"
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
                    Showing {{ $types->firstItem() ?? 1 }} to {{ $types->lastItem() ?? $types->count() }} of
                    {{ $types->total() }} results
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($types->onFirstPage())
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $types->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif

                    <span class="text-muted small mx-2">
                        Page {{ $types->currentPage() }} of {{ $types->lastPage() }}
                    </span>

                    @if ($types->hasMorePages())
                        <a href="{{ $types->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Add Equipment Type</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.equipment-types.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" class="form-control rounded-3 border-2" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control rounded-3 border-2" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i
                                class="fas fa-save me-2"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Equipment Type</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" id="editName" class="form-control rounded-3 border-2" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="editDescription" class="form-control rounded-3 border-2"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i
                                class="fas fa-save me-2"></i>Update</button>
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
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Equipment Type</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4 px-4 pb-2 text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Are you sure?</h6>
                    <p class="text-muted mb-0">You are about to delete: <strong id="deleteTypeName"></strong></p>
                    <p id="deleteWarningText" class="text-danger small mt-2 d-none fw-bold"></p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteForm" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3">
                            <i class="fas fa-trash me-2"></i>Delete Type
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function populateEditForm(button) {
            const id = button.getAttribute('data-type-id');
            const name = button.getAttribute('data-type-name');
            const description = button.getAttribute('data-type-description');

            document.getElementById('editForm').action = `/manager/equipment-types/${id}`;
            document.getElementById('editName').value = name || '';
            document.getElementById('editDescription').value = description || '';
        }

        function setDeleteForm(button) {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const count = parseInt(button.dataset.count);

            document.getElementById('deleteForm').action = `/manager/equipment-types/${id}`;
            document.getElementById('deleteTypeName').textContent = name;

            const warningText = document.getElementById('deleteWarningText');
            if (count > 0) {
                warningText.textContent = `This type is used by ${count} equipment. Deleting this type will delete all equipment`;
                warningText.classList.remove('d-none');
            } else {
                warningText.classList.add('d-none');
            }
        }
    </script>
@endpush