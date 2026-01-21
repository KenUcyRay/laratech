@extends('layouts.app')

@section('title', 'Data Operator')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Operator</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.operators.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Operator
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($operators as $operator)
                <tr class="{{ $operator->deleted_at ? 'table-secondary' : '' }}">
                    <td>{{ $operator->id }}</td>
                    <td>{{ $operator->name }}</td>
                    <td>{{ $operator->username }}</td>
                    <td>
                        @if($operator->deleted_at)
                            <span class="badge bg-secondary">Deleted</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>{{ $operator->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($operator->deleted_at)
                            <form action="{{ route('admin.operators.restore', $operator->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Restore this operator?')">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.operators.show', $operator) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.operators.edit', $operator) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.operators.destroy', $operator) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this operator?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No operators found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
{{ $operators->links('custom.admin-pagination') }}
@endsection