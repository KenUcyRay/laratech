@extends('layouts.app')

@section('title', 'Users Management')

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
            <i class="fas fa-users" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Users Management</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        👥 Kelola pengguna dan hak akses sistem
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-light btn-lg rounded-3 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#createUserModal">
                        <i class="fas fa-plus me-2"></i>Add User
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card border-0 shadow-lg rounded-4"
        style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">👥 All Users</h5>
                <span class="badge bg-primary rounded-pill fs-6">{{ $users->total() }} users</span>
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
                            <th class="fw-semibold border-0 py-3">Role</th>
                            <th class="fw-semibold border-0 py-3">Status</th>
                            <th class="fw-semibold border-0 py-3">Created</th>
                            <th class="fw-semibold border-0 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-0 {{ $user->deleted_at ? 'table-secondary' : '' }}">
                                <td class="fw-medium py-3">{{ $user->id }}</td>
                                <td class="fw-medium py-3">{{ $user->name }}</td>
                                <td class="py-3">{{ $user->username }}</td>
                                <td class="py-3">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger rounded-pill px-3 py-2">Admin</span>
                                    @elseif($user->role === 'operator')
                                        <span class="badge bg-warning rounded-pill px-3 py-2">Operator</span>
                                    @elseif($user->role === 'mekanik')
                                        <span class="badge bg-info rounded-pill px-3 py-2">Mekanik</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ ucfirst($user->role) }}</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if($user->deleted_at)
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">Deleted</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                                    @endif
                                </td>
                                <td class="py-3">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="py-3">
                                    @if($user->deleted_at)
                                        <button class="btn btn-sm btn-success rounded-3" data-bs-toggle="modal"
                                            data-bs-target="#restoreUserModal"
                                            onclick="setRestoreForm('{{ $user->id }}', '{{ addslashes($user->name) }}')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @else
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-warning rounded-start" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal" data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                data-user-username="{{ $user->username }}"
                                                data-user-role="{{ $user->role }}"
                                                onclick="populateEditForm(this)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal"
                                                onclick="setDeleteForm('{{ $user->id }}', '{{ addslashes($user->name) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fs-3 mb-2"></i>
                                        <p class="mb-0">No users found</p>
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
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($users->onFirstPage())
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif

                    <span class="text-muted small mx-2">
                        Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                    </span>

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Create New User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
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
                            <label class="form-label fw-semibold">Role</label>
                            <select class="form-control rounded-3 border-2" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="operator">Operator</option>
                                <option value="mekanik">Mekanik</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editUserForm">
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
                            <label class="form-label fw-semibold">Role</label>
                            <select class="form-control rounded-3 border-2" name="role" id="editRole" required>
                                <option value="admin">Admin</option>
                                <option value="operator">Operator</option>
                                <option value="mekanik">Mekanik</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Password (optional)</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" class="form-control rounded-3 border-2" name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold mb-2">Are you sure?</h6>
                <p class="text-muted mb-0">You are about to delete the user: <strong id="deleteUserName"></strong></p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center">
                <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST" id="deleteUserForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3">
                        <i class="fas fa-trash me-2"></i>Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Restore User Modal -->
<div class="modal fade" id="restoreUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4"
                style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-undo me-2"></i>Restore User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-question-circle text-info" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold mb-2">Restore User?</h6>
                <p class="text-muted mb-0">You are about to restore the user: <strong id="restoreUserName"></strong></p>
                <p class="text-muted small">This will make the user active again.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center">
                <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST" id="restoreUserForm" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success rounded-3">
                        <i class="fas fa-undo me-2"></i>Restore User
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
        const id = button.getAttribute('data-user-id');
        const name = button.getAttribute('data-user-name');
        const username = button.getAttribute('data-user-username');
        const role = button.getAttribute('data-user-role');

        document.getElementById('editUserForm').action = `/admin/users/${id}`;
        document.getElementById('editName').value = name || '';
        document.getElementById('editUsername').value = username || '';
        document.getElementById('editRole').value = role || '';
    }

    function setDeleteForm(id, name) {
        document.getElementById('deleteUserForm').action = `/admin/users/${id}`;
        document.getElementById('deleteUserName').textContent = name;
    }

    function setRestoreForm(id, name) {
        document.getElementById('restoreUserForm').action = `/admin/users/${id}/restore`;
        document.getElementById('restoreUserName').textContent = name;
    }
</script>
@endpush