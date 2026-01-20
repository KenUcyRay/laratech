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
                            <th>Type</th>
                            <th>Last Service</th>
                            <th>Next Service</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenances as $m)
                            <tr id="row-{{ $m->id }}">
                                <td>{{ $m->equipment->name ?? '-' }}</td>
                                <td>{{ $m->schedule_type }}</td>
                                <td>{{ $m->last_service ? $m->last_service->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <span class="{{ $m->next_service <= now() ? 'text-danger fw-bold' : '' }}">
                                        {{ $m->next_service ? $m->next_service->format('Y-m-d') : '-' }}
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
                            <label>Schedule Type</label>
                            <select name="schedule_type" class="form-select">
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="500-hours">500 Hours</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Last Service</label>
                            <input type="date" name="last_service" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Next Service</label>
                            <input type="date" name="next_service" class="form-control" required>
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