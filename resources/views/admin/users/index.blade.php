@extends('layouts.app')

@section('title', 'Users Management')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);">
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
                <a href="{{ route('admin.users.create') }}" class="btn btn-light rounded-pill px-4 py-3 shadow" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-plus me-2 text-primary"></i>
                    <span class="fw-semibold text-dark">Add User</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Users Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">ID</th>
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Username</th>
                            <th class="fw-semibold">Role</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Created</th>
                            <th class="fw-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="{{ $user->deleted_at ? 'table-secondary' : '' }}">
                                <td class="fw-medium">{{ $user->id }}</td>
                                <td class="fw-medium">{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'operator' ? 'warning' : 'info') }} rounded-pill">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->deleted_at)
                                        <span class="badge bg-secondary rounded-pill">Deleted</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">Active</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($user->deleted_at)
                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill" onclick="return confirm('Restore this user?')">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning rounded-pill me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Delete this user?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
            
            {{-- Pagination --}}
            {{ $users->links('custom.admin-pagination') }}
        </div>
    </div>

</div>
@endsection