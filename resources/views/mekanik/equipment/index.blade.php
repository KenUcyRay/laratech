@extends('layouts.app')

@section('title', 'Equipment Inventory')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Equipment Inventory & Status</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
</div>

<!-- Equipment Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-warning">Equipment List</h6>
    </div>
    <div class="card-body">
        @if($equipments->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="15%">Code</th>
                            <th width="25%">Name</th>
                            <th width="20%">Type</th>
                            <th width="20%">Current Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $eq)
                        <tr id="row-{{ $eq->id }}">
                            <td><span class="badge bg-secondary">{{ $eq->code }}</span></td>
                            <td>{{ $eq->name }}</td>
                            <td>{{ $eq->type->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $eq->status == 'idle' ? 'secondary' : ($eq->status == 'operasi' ? 'success' : ($eq->status == 'rusak' ? 'danger' : 'warning')) }}">
                                    {{ ucfirst($eq->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info update-status-btn text-white" 
                                        data-id="{{ $eq->id }}" 
                                        data-status="{{ $eq->status }}"
                                        data-name="{{ $eq->name }}">
                                    <i class="fas fa-edit"></i> Update Status
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Equipment Found</h5>
                <p class="text-muted">There are currently no equipment items to display.</p>
            </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="statusForm">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title text-white">Update Status: <span id="eqName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="eqId">
                    <div class="mb-3">
                        <label class="form-label">New Status</label>
                        <select name="status" class="form-select" required>
                            <option value="idle">Idle</option>
                            <option value="operasi">Operasi</option>
                            <option value="rusak">Rusak</option>
                            <option value="servis">Servis</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.update-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            let name = this.dataset.name;
            let currentStatus = this.dataset.status;
            
            document.getElementById('eqId').value = id;
            document.getElementById('eqName').innerText = name;
            document.querySelector(`select[name="status"]`).value = currentStatus;
            
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        });
    });

    document.getElementById('statusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let id = document.getElementById('eqId').value;
        let status = document.querySelector(`select[name="status"]`).value;

        fetch(`/mekanik/inventory/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                _method: 'PUT',
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    });
</script>
@endpush
@endsection