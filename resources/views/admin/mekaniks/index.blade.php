@extends('layouts.app')

@section('title', 'Data Mekanik')

@section('sidebar')
    @include('components.admin-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Mekanik</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.mekaniks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Mekanik
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
            @forelse($mekaniks as $mekanik)
                <tr class="{{ $mekanik->deleted_at ? 'table-secondary' : '' }}">
                    <td>{{ $mekanik->id }}</td>
                    <td>{{ $mekanik->name }}</td>
                    <td>{{ $mekanik->username }}</td>
                    <td>
                        @if($mekanik->deleted_at)
                            <span class="badge bg-secondary">Deleted</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>{{ $mekanik->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($mekanik->deleted_at)
                            <form action="{{ route('admin.mekaniks.restore', $mekanik->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Restore this mekanik?')">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.mekaniks.show', $mekanik) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.mekaniks.edit', $mekanik) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.mekaniks.destroy', $mekanik) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this mekanik?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No mekaniks found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection