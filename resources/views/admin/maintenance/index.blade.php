@extends('layouts.app')

@section('title', 'Maintenance Schedule')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Maintenance Schedule</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add Schedule
            </button>
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
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $m->id }}">Delete</button>
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
                        <h5 class="modal-title">Schedule Maintenance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Equipment</label>
                            <select name="equipment_id" class="form-select" required>
                                @foreach($equipments as $eq)
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

    @push('scripts')
        <script>
            document.getElementById('createForm').addEventListener('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                fetch("{{ route('admin.maintenance.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') location.reload();
                        else alert('Error: ' + JSON.stringify(data));
                    });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    if (!confirm('Delete schedule?')) return;
                    let id = this.dataset.id;
                    fetch(`/admin/maintenance/${id}`, {
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