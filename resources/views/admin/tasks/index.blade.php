@extends('layouts.app')

@section('title', 'Task Management')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Task Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Create Task
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Equipment</th>
                            <th>Assigned To</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr id="row-{{ $task->id }}">
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->equipment->name ?? '-' }}</td>
                                <td>{{ $task->assignee->name ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $task->status == 'done' ? 'success' : ($task->status == 'doing' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $task->id }}">Delete</button>
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
                        <h5 class="modal-title">Create Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Equipment</label>
                            <select name="equipment_id" class="form-select" required>
                                @foreach($equipments as $eq)
                                    <option value="{{ $eq->id }}">{{ $eq->name }} ({{ $eq->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Assign To</label>
                            <select name="assigned_to" class="form-select" required>
                                @foreach($assignees as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Priority</label>
                            <select name="priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                        <input type="hidden" name="status" value="todo">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
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

                fetch("{{ route('admin.tasks.store') }}", {
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
                    if (!confirm('Delete task?')) return;
                    let id = this.dataset.id;
                    fetch(`/admin/tasks/${id}`, {
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