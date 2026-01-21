@extends('layouts.app')

@section('title', 'Equipment Management')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@push('styles')
<style>
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
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tools me-2"></i>Equipment Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>Add Equipment
            </button>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipment Inventory</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
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
                                    <img src="{{ $eq->images->first()->image_url }}" alt="img" width="50" class="rounded-3">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $eq->code }}</td>
                            <td>{{ $eq->name }}</td>
                            <td>{{ $eq->type->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $eq->status == 'idle' ? 'secondary' : ($eq->status == 'operasi' ? 'success' : ($eq->status == 'rusak' ? 'danger' : 'warning')) }}">
                                    {{ ucfirst($eq->status) }}
                                </span>
                            </td>
                            <td>{{ $eq->hour_meter }}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-1 view-btn" data-id="{{ $eq->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="{{ $eq->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $eq->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
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
    <div class="modal-dialog modal-dialog-centered">
        <form id="createForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="equipment_type_id" class="form-select" required>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="idle">Idle</option>
                            <option value="operasi">Operasi</option>
                            <option value="rusak">Rusak</option>
                            <option value="servis">Servis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hour Meter</label>
                        <input type="number" name="hour_meter" class="form-control" min="0" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Images</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Equipment</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('createForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

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
                alert('Error: ' + JSON.stringify(data));
            }
        });
});

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