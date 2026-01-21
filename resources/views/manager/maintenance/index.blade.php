@extends('layouts.app')

@section('title', 'Maintenance Schedule')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@push('styles')
<style>
.btn-outline-primary {
    color: #374151;
    border-color: #374151;
    background: transparent;
}
.btn-outline-primary:hover {
    color: #ffffff;
    background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
    border-color: #4b5563;
    box-shadow: 0 2px 4px rgba(75, 85, 99, 0.3);
}
.border-left-primary {
    border-left: 0.25rem solid #7c3aed !important;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-check me-2"></i>Maintenance Schedule</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus me-2"></i>Add Schedule
            </button>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Maintenance Schedule</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Assignee</th>
                        <th>Last Service Date</th>
                        <th>Next Service Due</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenances as $m)
                        <tr id="row-{{ $m->id }}">
                            <td>{{ $m->equipment->name ?? '-' }}</td>
                            <td>{{ $m->assignee->name ?? '-' }} ({{ ucfirst($m->assignee->role ?? '') }})</td>
                            <td>{{ $m->last_service_date ? $m->last_service_date->format('d M Y H:i') : '-' }}</td>
                            <td>
                                {{ $m->next_service_due ? $m->next_service_due->format('d M Y H:i') : '-' }}
                            </td>
                            <td>
                                @php
                                    $isDue = now()->greaterThanOrEqualTo($m->next_service_due);
                                    $isClose = now()->addDays(2)->greaterThanOrEqualTo($m->next_service_due);
                                @endphp
                                <span class="badge bg-{{ $isDue ? 'danger' : ($isClose ? 'warning' : 'success') }}">
                                    {{ $isDue ? 'Overdue' : ($isClose ? 'Upcoming' : 'OK') }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $m->id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $m->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing {{ $maintenances->firstItem() ?? 1 }} to {{ $maintenances->lastItem() ?? $maintenances->count() }} of {{ $maintenances->total() }} results
            </div>
            <div class="d-flex align-items-center gap-2">
                @if ($maintenances->onFirstPage())
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                @else
                    <a href="{{ $maintenances->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @endif
                
                <span class="text-muted small mx-2">
                    Page {{ $maintenances->currentPage() }} of {{ $maintenances->lastPage() }}
                </span>
                
                @if ($maintenances->hasMorePages())
                    <a href="{{ $maintenances->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="createForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Schedule Maintenance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Equipment</label>
                            <select name="equipment_id" class="form-select" required>
                                @foreach($availableEquipments as $eq)
                                    <option value="{{ $eq->id }}">{{ $eq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Assign To</label>
                            <select name="user_id" class="form-select" required>
                                @foreach($assignees as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Last Service Date (Optional)</label>
                            <input type="date" name="last_service_date" class="form-control">
                            <small class="text-muted">Next service will be automatically set to +1500 hours from this date
                                (or now).</small>
                        </div>
                    </div>
                    <div class="modal-footer">
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
                        <h5 class="modal-title">Edit Maintenance Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Equipment</label>
                            <select name="equipment_id" id="editEquipmentId" class="form-select" required>
                                @foreach($equipments as $eq)
                                    <option value="{{ $eq->id }}">{{ $eq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Assign To</label>
                            <select name="user_id" id="editUserId" class="form-select" required>
                                @foreach($assignees as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Last Service Date (Optional)</label>
                            <input type="date" name="last_service_date" id="editLastServiceDate" class="form-control">
                            <small class="text-muted">Next service will be automatically set to +1500 hours from this date
                                (or now).</small>
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
            document.addEventListener('DOMContentLoaded', function () {
                console.log('Maintenance script loaded');

                // Event Delegation for Table Actions
                document.body.addEventListener('click', function(e) {
                    // Edit Button
                    const editBtn = e.target.closest('.edit-btn');
                    if (editBtn) {
                        e.preventDefault();
                        console.log('Edit clicked', editBtn.dataset.id);
                        
                        const id = editBtn.dataset.id;
                        if (!id) return;

                        // Show some feedback (optional)
                        editBtn.disabled = true;
                        editBtn.innerHTML = 'Loading...';

                        fetch(`/manager/maintenance/${id}`, {
                            headers: { "Accept": "application/json" }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                const m = data.data;
                                document.getElementById('editId').value = m.id;
                                document.getElementById('editEquipmentId').value = m.equipment_id;
                                document.getElementById('editUserId').value = m.user_id;

                                if (m.last_service_date) {
                                    let dateStr = m.last_service_date;
                                    // Handle T separator or space
                                    dateStr = dateStr.includes('T') ? dateStr.split('T')[0] : dateStr.split(' ')[0];
                                    document.getElementById('editLastServiceDate').value = dateStr;
                                } else {
                                    document.getElementById('editLastServiceDate').value = '';
                                }
                                
                                const modalEl = document.getElementById('editModal');
                                if (modalEl && window.bootstrap) {
                                    const modal = new window.bootstrap.Modal(modalEl);
                                    modal.show();
                                } else {
                                    console.error('Edit modal element not found or Bootstrap not loaded');
                                    alert('Error: custom bootstrap check failed.');
                                }
                            } else {
                                alert('Failed to fetch data: ' + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching maintenance data:', error);
                            alert('Failed to load data. Please try again.');
                        })
                        .finally(() => {
                            editBtn.disabled = false;
                            editBtn.innerHTML = 'Edit';
                        });
                    }

                    // Delete Button
                    const deleteBtn = e.target.closest('.delete-btn');
                    if (deleteBtn) {
                        e.preventDefault();
                        console.log('Delete clicked', deleteBtn.dataset.id);

                        if (!confirm('Delete schedule?')) return;
                        
                        const id = deleteBtn.dataset.id;
                        
                        fetch(`/manager/maintenance/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const row = document.getElementById(`row-${id}`);
                                if (row) row.remove();
                            } else {
                                alert(data.message || 'Failed to delete');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting:', error);
                            alert('Failed to delete. Check console.');
                        });
                    }
                });

                // Create Form
                const createForm = document.getElementById('createForm');
                if (createForm) {
                    createForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const formData = new FormData(this);

                        fetch("{{ route('manager.maintenance.store') }}", {
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
                                alert(data.message || 'Error: ' + JSON.stringify(data));
                            }
                        })
                        .catch(error => {
                            console.error('Error creating:', error);
                            alert('An error occurred. Please check console.');
                        });
                    });
                }

                // Update Form
                const editForm = document.getElementById('editForm');
                if (editForm) {
                    editForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const id = document.getElementById('editId').value;
                        const formData = new FormData(this);
                        formData.append('_method', 'PUT');

                        fetch(`/manager/maintenance/${id}`, {
                            method: "POST", // Method spoofing for PUT
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
                                alert(data.message || 'Error: ' + JSON.stringify(data));
                            }
                        })
                        .catch(error => {
                            console.error('Error updating:', error);
                            alert('Failed to update. Check console.');
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection