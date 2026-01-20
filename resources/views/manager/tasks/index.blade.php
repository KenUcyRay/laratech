@extends('layouts.app')

@section('title', 'Task Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            @include('components.manager-sidebar')
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Task Management</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal">
                    <i class="fas fa-plus"></i> Create Task
                </button>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Equipment</th>
                                    <th>Assigned To</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->equipment->name ?? 'N/A' }}</td>
                                    <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                    <td>
                                        @if($task->priority == 'high')
                                            <span class="badge badge-danger">High</span>
                                        @elseif($task->priority == 'medium')
                                            <span class="badge badge-warning">Medium</span>
                                        @else
                                            <span class="badge badge-info">Low</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->status == 'todo')
                                            <span class="badge badge-secondary">Todo</span>
                                        @elseif($task->status == 'doing')
                                            <span class="badge badge-warning">Doing</span>
                                        @elseif($task->status == 'done')
                                            <span class="badge badge-success">Done</span>
                                        @else
                                            <span class="badge badge-dark">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-task" data-id="{{ $task->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-task" data-id="{{ $task->id }}">
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
        </div>
    </div>
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Task</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="createTaskForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Equipment</label>
                        <select class="form-control" name="equipment_id" required>
                            <option value="">Select Equipment</option>
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Assign To</label>
                        <select class="form-control" name="assigned_to" required>
                            <option value="">Select Person</option>
                            @foreach($assignees as $assignee)
                                <option value="{{ $assignee->id }}">{{ $assignee->name }} ({{ ucfirst($assignee->role) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <select class="form-control" name="priority" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" class="form-control" name="due_date">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="todo">Todo</option>
                            <option value="doing">Doing</option>
                            <option value="done">Done</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#createTaskForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("manager.tasks.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#createTaskModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error creating task');
            }
        });
    });
});
</script>
@endsection