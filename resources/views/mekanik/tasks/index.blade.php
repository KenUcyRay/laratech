@extends('layouts.app')

@section('title', $pageTitle)

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tasks"
                    style="font-size: 8rem; color: white; transform: rotate(15deg);  margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">{{ $pageTitle }}</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            ⚙️ Repair and maintenance tasks
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tasks Table --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($tasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="fw-semibold" width="25%">Title</th>
                                    <th class="fw-semibold" width="20%">Equipment</th>
                                    <th class="fw-semibold" width="12%">Priority</th>
                                    <th class="fw-semibold" width="12%">Status</th>
                                    <th class="fw-semibold" width="13%">Due Date</th>
                                    <th class="fw-semibold" width="18%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr id="row-{{ $task->id }}">
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->equipment->name ?? '-' }} <small
                                                class="text-muted">({{ $task->equipment->code ?? '' }})</small></td>
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
                                            @if(isset($allowStart) && $allowStart && $task->status == 'todo')
                                                <button class="btn btn-sm btn-warning start-task-btn" data-id="{{ $task->id }}">
                                                    <i class="fas fa-play"></i> Start
                                                </button>
                                            @endif

                                            @if(isset($allowComplete) && $allowComplete && $task->status == 'doing')
                                                <button class="btn btn-sm btn-success complete-task-btn" data-id="{{ $task->id }}">
                                                    <i class="fas fa-check"></i> Complete
                                                </button>
                                            @endif

                                            @if($task->status == 'done')
                                                <span class="text-success"><i class="fas fa-check-circle"></i> Done</span>
                                            @endif

                                            <button class="btn btn-sm btn-info text-white view-task-btn"
                                                data-title="{{ $task->report ? $task->report->description : $task->title }}"
                                                data-equipment="{{ $task->equipment->name ?? '-' }}"
                                                data-priority="{{ ucfirst($task->priority) }}"
                                                data-status="{{ ucfirst($task->status) }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{ $tasks->links('custom.mekanik-pagination') }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-4 opacity-50"></i>
                        <h5 class="text-muted fw-semibold">No Tasks Found</h5>
                        <p class="text-muted mb-0">There are currently no {{ strtolower($pageTitle) }} to display.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Task Detail Modal --}}
    <div class="modal fade" id="taskDetailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-tasks me-2"></i>Task Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-semibold text-uppercase small text-muted mb-2"
                            style="letter-spacing: 0.5px;">Equipment:</label>
                        <p id="modalTaskEquipment" class="fs-6 text-dark mb-0">-</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold text-uppercase small text-muted mb-2" style="letter-spacing: 0.5px;">Full
                            Title / Description:</label>
                        <p id="modalTaskTitle" class="bg-light p-3 rounded fs-6">-</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong class="text-muted small">Priority:</strong> <span id="modalTaskPriority"
                                class="fw-semibold">-</span>
                        </div>
                        <div>
                            <strong class="text-muted small">Status:</strong> <span id="modalTaskStatus"
                                class="fw-semibold">-</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // View Task Detail
            document.querySelectorAll('.view-task-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('modalTaskEquipment').textContent = this.dataset.equipment;
                    document.getElementById('modalTaskTitle').textContent = this.dataset.title;
                    document.getElementById('modalTaskPriority').textContent = this.dataset.priority;
                    document.getElementById('modalTaskStatus').textContent = this.dataset.status;

                    new bootstrap.Modal(document.getElementById('taskDetailModal')).show();
                });
            });

            // Start Task
            document.querySelectorAll('.start-task-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    updateTaskStatus(id, 'doing');
                });
            });

            // Complete Task
            document.querySelectorAll('.complete-task-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;
                    updateTaskStatus(id, 'done');
                });
            });

            function updateTaskStatus(id, status) {
                if (!confirm('Are you sure you want to update task status to ' + status + '?')) return;

                fetch(`/mekanik/work-orders/${id}`, {
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
                        if (data.status === 'success') {
                            location.reload();
                        } else {
                            alert('Error: ' + JSON.stringify(data));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to update task.');
                    });
            }
        </script>
    @endpush
@endsection