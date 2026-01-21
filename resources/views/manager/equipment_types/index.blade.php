@extends('layouts.app')

@section('title', 'Equipment Types')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #7c3aed !important;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tags me-2"></i>Equipment Types</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>Add New Type
            </button>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipment Types Management</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Associated Equipments</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                        <tr id="row-{{ $type->id }}">
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->description }}</td>
                            <td>{{ $type->equipments_count }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $type->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $type->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="createForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Equipment Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm">
            <input type="hidden" name="id" id="editId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Equipment Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Create
document.getElementById('createForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch("{{ route('manager.equipment-types.store') }}", {
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

// Delete
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        if (!confirm('Are you sure?')) return;
        let id = this.dataset.id;
        fetch(`/manager/equipment-types/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById(`row-${id}`).remove();
                } else {
                    alert(data.message);
                }
            });
    });
});

// Edit
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        let id = this.dataset.id;
        fetch(`/manager/equipment-types/${id}/edit`, {
            headers: { "Accept": "application/json" }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let type = data.data;
                    document.getElementById('editId').value = type.id;
                    document.getElementById('editName').value = type.name;
                    document.getElementById('editDescription').value = type.description;
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                }
            });
    });
});

// Update
document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let id = document.getElementById('editId').value;
    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/manager/equipment-types/${id}`, {
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
</script>
@endpush