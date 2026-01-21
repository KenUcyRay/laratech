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
    <div class="position-relative overflow-hidden rounded-4 shadow-lg my-4"
        style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-calendar-check"
                style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Maintenance Schedule</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🔧 Plan and track equipment maintenance schedules
                    </p>
                </div>
                <div>
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-2"></i>Add Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-transparent border-0 p-4">
            <h5 class="mb-0 fw-bold">📅 Maintenance Schedule</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="fw-semibold">Equipment</th>
                            <th class="fw-semibold">Assignee</th>
                            <th class="fw-semibold">Last Service Date</th>
                            <th class="fw-semibold">Next Service Due</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Action</th>
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
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning rounded-start" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-maintenance-id="{{ $m->id }}"
                                            data-maintenance-equipment="{{ $m->equipment_id }}"
                                            data-maintenance-user="{{ $m->user_id }}"
                                            data-maintenance-date="{{ $m->last_service_date ? $m->last_service_date->format('Y-m-d') : '' }}"
                                            onclick="populateEditForm(this)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            onclick="setDeleteForm({{ $m->id }}, '{{ addslashes($m->equipment->name ?? 'N/A') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $maintenances->firstItem() ?? 1 }} to
                    {{ $maintenances->lastItem() ?? $maintenances->count() }} of {{ $maintenances->total() }} results
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
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Schedule Maintenance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.maintenance.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Equipment</label>
                            <select name="equipment_id" class="form-select rounded-3 border-2" required>
                                <option value="">Select Equipment</option>
                                @foreach($availableEquipments as $eq)
                                    <option value="{{ $eq->id }}">{{ $eq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assign To</label>
                            <select name="user_id" class="form-select rounded-3 border-2" required>
                                <option value="">Select Assignee</option>
                                @foreach($assignees as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Last Service Date (Optional)</label>
                            <input type="date" name="last_service_date" class="form-control rounded-3 border-2">
                            <div class="form-text">Next service will be automatically set to +1500 hours from this date (or
                                now).</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Save
                            Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Maintenance Schedule
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Equipment</label>
                            <select name="equipment_id" id="editEquipmentId" class="form-select rounded-3 border-2"
                                required>
                                @foreach($equipments as $eq)
                                    <option value="{{ $eq->id }}">{{ $eq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assign To</label>
                            <select name="user_id" id="editUserId" class="form-select rounded-3 border-2" required>
                                @foreach($assignees as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Last Service Date (Optional)</label>
                            <input type="date" name="last_service_date" id="editLastServiceDate"
                                class="form-control rounded-3 border-2">
                            <div class="form-text">Next service will be automatically set to +1500 hours from this date (or
                                now).</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update
                            Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Maintenance Schedule
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Are you sure?</h6>
                    <p class="text-muted mb-0">You are about to delete maintenance schedule for: <strong
                            id="deleteMaintenanceName"></strong></p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 p-4 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteForm" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3"><i class="fas fa-trash me-2"></i>Delete
                            Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function populateEditForm(button) {
                const id = button.dataset.maintenanceId;
                document.getElementById('editForm').action = `/manager/maintenance/${id}`;
                document.getElementById('editEquipmentId').value = button.dataset.maintenanceEquipment;
                document.getElementById('editUserId').value = button.dataset.maintenanceUser;
                document.getElementById('editLastServiceDate').value = button.dataset.maintenanceDate;
            }

            function setDeleteForm(id, equipmentName) {
                document.getElementById('deleteForm').action = `/manager/maintenance/${id}`;
                document.getElementById('deleteMaintenanceName').textContent = equipmentName;
            }
        </script>
    @endpush
@endsection