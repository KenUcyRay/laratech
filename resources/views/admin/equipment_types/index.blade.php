@extends('layouts.app')

@section('title', 'Equipment Types')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Equipment Types Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New Type
            </button>
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
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal Placeholder (Dynamic or Static) -->
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
                            <label>Name</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" id="editDescription" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Simple AJAX handling for Create/Edit/Delete
            // User requested JSON response structure, so frontend must handle it.

            // Create
            document.getElementById('createForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                fetch("{{ route('admin.equipment-types.store') }}", {
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
                    fetch(`/admin/equipment-types/${id}`, {
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

            // Edit (Fetch and Populate)
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    fetch(`/admin/equipment-types/${id}/edit`, {
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
                formData.append('_method', 'PUT'); // Method spoofing

                fetch(`/admin/equipment-types/${id}`, {
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
@endsection