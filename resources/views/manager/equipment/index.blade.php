@extends('layouts.app')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@section('title', 'Equipment Inventory')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Equipment Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add Equipment
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Hour Meter</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $eq)
                            <tr id="row-{{ $eq->id }}">
                                <td>
                                    @if($eq->images->count() > 0)
                                        <img src="{{ $eq->images->first()->image_url }}" alt="img" width="50">
                                    @else
                                        -
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
                                    <button class="btn btn-sm btn-info view-btn" data-id="{{ $eq->id }}">Detail</button>
                                    <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $eq->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $eq->id }}">Delete</button>
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
            <form id="createForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Equipment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <select name="equipment_type_id" class="form-select" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="idle">Idle</option>
                                <option value="operasi">Operasi</option>
                                <option value="rusak">Rusak</option>
                                <option value="servis">Servis</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Hour Meter</label>
                            <input type="number" name="hour_meter" class="form-control" min="0" value="0">
                        </div>
                        <div class="mb-3">
                            <label>Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
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

                // Show loading state...

                fetch("{{ route('manager.equipment.store') }}", {
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
                            alert('Error: ' + JSON.stringify(data)); // Better error handling needed
                        }
                    });
            });

            // Delete logic...
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    if (!confirm('Delete equipment?')) return;
                    let id = this.dataset.id;
                    fetch(`/manager/equipment/${id}`, {
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