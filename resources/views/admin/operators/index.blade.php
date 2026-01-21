@extends('layouts.app')

@section('title', 'Data Operator')

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
            <i class="fas fa-desktop" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Data Operator</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        💻 Kelola data operator sistem
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-light btn-lg rounded-3 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#createOperatorModal">
                        <i class="fas fa-plus me-2"></i>Add Operator
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Operators Table --}}
    <div class="card border-0 shadow-lg rounded-4"
        style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">💻 All Operators</h5>
                <span class="badge bg-primary rounded-pill fs-6">{{ $operators->total() }} operators</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 py-3">ID</th>
                            <th class="fw-semibold border-0 py-3">Name</th>
                            <th class="fw-semibold border-0 py-3">Username</th>
                            <th class="fw-semibold border-0 py-3">Status</th>
                            <th class="fw-semibold border-0 py-3">Created</th>
                            <th class="fw-semibold border-0 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($operators as $operator)
                            <tr class="border-0 {{ $operator->deleted_at ? 'table-secondary' : '' }}">
                                <td class="fw-medium py-3">{{ $operator->id }}</td>
                                <td class="fw-medium py-3">{{ $operator->name }}</td>
                                <td class="py-3">{{ $operator->username }}</td>
                                <td class="py-3">
                                    @if($operator->deleted_at)
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">Deleted</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                                    @endif
                                </td>
                                <td class="py-3">{{ $operator->created_at->format('M d, Y') }}</td>
                                <td class="py-3">
                                    @if($operator->deleted_at)
                                        <button class="btn btn-sm btn-success rounded-3" data-bs-toggle="modal"
                                            data-bs-target="#restoreOperatorModal"
                                            onclick="setRestoreForm('{{ $operator->id }}', '{{ addslashes($operator->name) }}')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @else
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.operators.show', $operator) }}" class="btn btn-sm btn-info rounded-start">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editOperatorModal" data-operator-id="{{ $operator->id }}"
                                                data-operator-name="{{ $operator->name }}"
                                                data-operator-username="{{ $operator->username }}"
                                                onclick="populateEditForm(this)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                                data-bs-target="#deleteOperatorModal"
                                                onclick="setDeleteForm('{{ $operator->id }}', '{{ addslashes($operator->name) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-desktop fs-3 mb-2"></i>
                                        <p class="mb-0">No operators found</p>
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
                    Showing {{ $operators->firstItem() }} to {{ $operators->lastItem() }} of {{ $operators->total() }} results
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($operators->onFirstPage())
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $operators->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif

                    <span class="text-muted small mx-2">
                        Page {{ $operators->currentPage() }} of {{ $operators->lastPage() }}
                    </span>

                    @if ($operators->hasMorePages())
                        <a href="{{ $operators->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

<!-- Create Operator Modal -->
<div class="modal fade" id="createOperatorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Create New Operator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.operators.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" class="form-control rounded-3 border-2" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control rounded-3 border-2" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Create Operator</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Operator Modal -->
<div class="modal fade" id="editOperatorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Operator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editOperatorForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" class="form-control rounded-3 border-2" name="name" id="editName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control rounded-3 border-2" name="username" id="editUsername" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Password (optional)</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update Operator</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Operator Modal -->
<div class="modal fade" id="deleteOperatorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Operator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold mb-2">Are you sure?</h6>
                <p class="text-muted mb-0">You are about to delete the operator: <strong id="deleteOperatorName"></strong></p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center">
                <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST" id="deleteOperatorForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3">
                        <i class="fas fa-trash me-2"></i>Delete Operator
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Restore Operator Modal -->
<div class="modal fade" id="restoreOperatorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-undo me-2"></i>Restore Operator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-question-circle text-info" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold mb-2">Restore Operator?</h6>
                <p class="text-muted mb-0">You are about to restore the operator: <strong id="restoreOperatorName"></strong></p>
                <p class="text-muted small">This will make the operator active again.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center">
                <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST" id="restoreOperatorForm" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success rounded-3">
                        <i class="fas fa-undo me-2"></i>Restore Operator
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
        const id = button.getAttribute('data-operator-id');
        const name = button.getAttribute('data-operator-name');
        const username = button.getAttribute('data-operator-username');

        document.getElementById('editOperatorForm').action = `/admin/operators/${id}`;
        document.getElementById('editName').value = name || '';
        document.getElementById('editUsername').value = username || '';
    }

    function setDeleteForm(id, name) {
        document.getElementById('deleteOperatorForm').action = `/admin/operators/${id}`;
        document.getElementById('deleteOperatorName').textContent = name;
    }

    function setRestoreForm(id, name) {
        document.getElementById('restoreOperatorForm').action = `/admin/operators/${id}/restore`;
        document.getElementById('restoreOperatorName').textContent = name;
    }
</script>
@endpush