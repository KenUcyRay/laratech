@extends('layouts.app')

@section('title', 'Task Management')

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
    </style>
@endpush

@section('content')
    <div class="container-fluid mt-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tasks" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Task Management</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            📋 Kelola dan monitor semua task tim
                        </p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-light btn-lg rounded-3 shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#createTaskModal">
                            <i class="fas fa-plus me-2"></i>Create Task
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Task Statistics Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-lg rounded-4 h-100"
                    style="background: linear-gradient(145deg, #3b82f6 0%, #1d4ed8 100%); transform: translateY(0); transition: all 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-list fs-3 text-black"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-1">{{ $taskCounts['total'] }}</h3>
                        <p class="text-white text-opacity-75 mb-0">Total Tasks</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-lg rounded-4 h-100"
                    style="background: linear-gradient(145deg, #6b7280 0%, #4b5563 100%); transform: translateY(0); transition: all 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-pause fs-3 text-black"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-1">{{ $taskCounts['todo'] }}</h3>
                        <p class="text-white text-opacity-75 mb-0">Todo Tasks</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-lg rounded-4 h-100"
                    style="background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); transform: translateY(0); transition: all 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-spinner fs-3 text-black"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-1">{{ $taskCounts['doing'] }}</h3>
                        <p class="text-white text-opacity-75 mb-0">In Progress</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-lg rounded-4 h-100"
                    style="background: linear-gradient(145deg, #10b981 0%, #059669 100%); transform: translateY(0); transition: all 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-check-circle fs-3 text-black"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-1">{{ $taskCounts['done'] }}</h3>
                        <p class="text-white text-opacity-75 mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tasks Table --}}
        <div class="card border-0 shadow-lg rounded-4"
            style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
            <div class="card-header bg-transparent border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-gray-800">📋 All Tasks</h5>
                    <span class="badge bg-primary rounded-pill fs-6">{{ $taskCounts['total'] }} tasks</span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold border-0 py-3">Title</th>
                                <th class="fw-semibold border-0 py-3">Equipment</th>
                                <th class="fw-semibold border-0 py-3">Assigned To</th>
                                <th class="fw-semibold border-0 py-3">Priority</th>
                                <th class="fw-semibold border-0 py-3">Status</th>
                                <th class="fw-semibold border-0 py-3">Due Date</th>
                                <th class="fw-semibold border-0 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr class="border-0">
                                    <td class="fw-medium py-3">{{ $task->title }}</td>
                                    <td class="py-3">{{ $task->equipment->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                    <td class="py-3">
                                        @if($task->priority == 'high')
                                            <span class="badge bg-danger rounded-pill px-3 py-2">High</span>
                                        @elseif($task->priority == 'medium')
                                            <span class="badge bg-warning rounded-pill px-3 py-2">Medium</span>
                                        @else
                                            <span class="badge bg-info rounded-pill px-3 py-2">Low</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($task->status == 'todo')
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">Todo</span>
                                        @elseif($task->status == 'doing')
                                            <span class="badge bg-warning rounded-pill px-3 py-2">Doing</span>
                                        @elseif($task->status == 'done')
                                            <span class="badge bg-success rounded-pill px-3 py-2">Done</span>
                                        @else
                                            <span class="badge bg-dark rounded-pill px-3 py-2">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="py-3">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="py-3">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-warning rounded-start" data-bs-toggle="modal"
                                                data-bs-target="#editTaskModal" data-task-id="{{ $task->id }}"
                                                data-task-title="{{ $task->title }}"
                                                data-task-equipment="{{ $task->equipment_id }}"
                                                data-task-assigned="{{ $task->assigned_to }}"
                                                data-task-priority="{{ $task->priority }}" data-task-due="{{ $task->due_date }}"
                                                data-task-status="{{ $task->status }}" onclick="populateEditFormFromData(this)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger rounded-end" data-bs-toggle="modal"
                                                data-bs-target="#deleteTaskModal"
                                                onclick="setDeleteForm('{{ $task->id }}', '{{ addslashes($task->title) }}')">
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
                        Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if ($tasks->onFirstPage())
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @else
                            <a href="{{ $tasks->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        @endif

                        <span class="text-muted small mx-2">
                            Page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }}
                        </span>

                        @if ($tasks->hasMorePages())
                            <a href="{{ $tasks->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Create New Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control rounded-3 border-2" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Equipment</label>
                                <select class="form-control rounded-3 border-2" name="equipment_id" required>
                                    <option value="">Select Equipment</option>
                                    @foreach($equipments as $equipment)
                                        <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Assign To</label>
                                <select class="form-control rounded-3 border-2" name="assigned_to" required>
                                    <option value="">Select Person</option>
                                    @foreach($assignees as $assignee)
                                        <option value="{{ $assignee->id }}">{{ $assignee->name }}
                                            ({{ ucfirst($assignee->role) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Priority</label>
                                <select class="form-control rounded-3 border-2" name="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Due Date</label>
                                <input type="date" class="form-control rounded-3 border-2" name="due_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Create
                            Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" id="editTaskForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" class="form-control rounded-3 border-2" name="title" id="editTitle"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Equipment</label>
                                <select class="form-control rounded-3 border-2" name="equipment_id" id="editEquipmentId"
                                    required>
                                    <option value="">Select Equipment</option>
                                    @foreach($equipments as $equipment)
                                        <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Assign To</label>
                                <select class="form-control rounded-3 border-2" name="assigned_to" id="editAssignedTo"
                                    required>
                                    <option value="">Select Person</option>
                                    @foreach($assignees as $assignee)
                                        <option value="{{ $assignee->id }}">{{ $assignee->name }}
                                            ({{ ucfirst($assignee->role) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Priority</label>
                                <select class="form-control rounded-3 border-2" name="priority" id="editPriority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Due Date</label>
                                <input type="date" class="form-control rounded-3 border-2" name="due_date" id="editDueDate">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-control rounded-3 border-2" name="status" id="editStatus" required>
                                    <option value="todo">Todo</option>
                                    <option value="doing">Doing</option>
                                    <option value="done">Done</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-2"></i>Update
                            Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Are you sure?</h6>
                    <p class="text-muted mb-0">You are about to delete the task: <strong id="deleteTaskTitle"></strong></p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 p-4 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteTaskForm" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3">
                            <i class="fas fa-trash me-2"></i>Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function populateEditFormFromData(button) {
            const id = button.getAttribute('data-task-id');
            const title = button.getAttribute('data-task-title');
            const equipmentId = button.getAttribute('data-task-equipment');
            const assignedTo = button.getAttribute('data-task-assigned');
            const priority = button.getAttribute('data-task-priority');
            const dueDate = button.getAttribute('data-task-due');
            const status = button.getAttribute('data-task-status');

            console.log('Edit data:', { id, title, equipmentId, assignedTo, priority, dueDate, status });

            document.getElementById('editTaskForm').action = `/manager/tasks/${id}`;
            document.getElementById('editTitle').value = title || '';
            document.getElementById('editEquipmentId').value = equipmentId || '';
            document.getElementById('editAssignedTo').value = assignedTo || '';
            document.getElementById('editPriority').value = priority || 'low';
            document.getElementById('editDueDate').value = dueDate || '';
            document.getElementById('editStatus').value = status || 'todo';
        }

        function populateEditForm(id, title, equipmentId, assignedTo, priority, dueDate, status) {
            console.log('Populating form with:', { id, title, equipmentId, assignedTo, priority, dueDate, status });

            document.getElementById('editTaskForm').action = `/manager/tasks/${id}`;
            document.getElementById('editTitle').value = title || '';
            document.getElementById('editEquipmentId').value = equipmentId || '';
            document.getElementById('editAssignedTo').value = assignedTo || '';
            document.getElementById('editPriority').value = priority || 'low';
            document.getElementById('editDueDate').value = dueDate || '';
            document.getElementById('editStatus').value = status || 'todo';
        }

        function setDeleteForm(id, title) {
            document.getElementById('deleteTaskForm').action = `/manager/tasks/${id}`;
            document.getElementById('deleteTaskTitle').textContent = title;
        }
    </script>
@endpush