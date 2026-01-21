@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

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
            style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tasks" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Tugas Saya</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            📋 Lihat dan update status tugas yang di-assign kepada Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Task Grid --}}
        <div class="row g-4">
            @forelse($tasks as $task)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg h-100 rounded-4"
                        style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%); transform: translateY(0); transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                {{-- Badge Status --}}
                                @php
                                    $statusConfig = [
                                        'todo' => ['color' => 'warning', 'emoji' => '🕐', 'bg' => 'rgba(255,193,7,0.1)', 'text' => 'Todo'],
                                        'doing' => ['color' => 'info', 'emoji' => '▶️', 'bg' => 'rgba(13,202,240,0.1)', 'text' => 'Doing'],
                                        'done' => ['color' => 'success', 'emoji' => '✅', 'bg' => 'rgba(25,135,84,0.1)', 'text' => 'Done'],
                                        'cancelled' => ['color' => 'danger', 'emoji' => '❌', 'bg' => 'rgba(220,53,69,0.1)', 'text' => 'Cancelled'],
                                    ];
                                    $statusConf = $statusConfig[$task->status] ?? $statusConfig['todo'];
                                @endphp
                                <div class="rounded-3 p-3" style="background: {{ $statusConf['bg'] }}">
                                    <span class="fs-4">{{ $statusConf['emoji'] }}</span>
                                </div>

                                {{-- Dropdown Update Status --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-3 shadow-sm" data-bs-toggle="dropdown"
                                        style="width: 40px; height: 40px;">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                        <li>
                                            <h6 class="dropdown-header fw-bold">Update Status</h6>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button type="button" class="dropdown-item {{ $task->status === 'todo' ? 'active' : '' }}"
                                                data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                                onclick="setUpdateForm('{{ $task->id }}', 'todo', '{{ addslashes($task->title) }}')">
                                                <i class="fas fa-clock me-2 text-warning"></i>Todo
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item {{ $task->status === 'doing' ? 'active' : '' }}"
                                                data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                                onclick="setUpdateForm('{{ $task->id }}', 'doing', '{{ addslashes($task->title) }}')">
                                                <i class="fas fa-play me-2 text-info"></i>Doing
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item {{ $task->status === 'done' ? 'active' : '' }}"
                                                data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                                onclick="setUpdateForm('{{ $task->id }}', 'done', '{{ addslashes($task->title) }}')">
                                                <i class="fas fa-check me-2 text-success"></i>Done
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item {{ $task->status === 'cancelled' ? 'active' : '' }}"
                                                data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                                onclick="setUpdateForm('{{ $task->id }}', 'cancelled', '{{ addslashes($task->title) }}')">
                                                <i class="fas fa-times me-2 text-danger"></i>Cancelled
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Task Title --}}
                            <h5 class="fw-bold text-dark mb-3">{{ $task->title }}</h5>

                            {{-- Status badge + Priority badge + Deadline --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-{{ $statusConf['color'] }} bg-opacity-10 text-{{ $statusConf['color'] }} border border-{{ $statusConf['color'] }} border-opacity-25 rounded-pill px-3 py-2">
                                        {{ $statusConf['text'] }}
                                    </span>
                                    @php
                                        $priorityConfig = [
                                            'low' => ['style' => 'background: rgba(108,117,125,0.1); color: #6c757d; border: 1px solid rgba(108,117,125,0.25);'],
                                            'medium' => ['style' => 'background: rgba(255,69,0,0.15); color: #ff4500; border: 1px solid rgba(255,69,0,0.4);'],
                                            'high' => ['style' => 'background: rgba(255,0,0,0.15); color: #dc143c; border: 1px solid rgba(255,0,0,0.4);'],
                                        ];
                                        $priorityConf = $priorityConfig[$task->priority] ?? $priorityConfig['low'];
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2" style="{{ $priorityConf['style'] }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                @if($task->due_date)
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $task->due_date->format('d/m/Y') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-clipboard-list fs-1 mb-3"></i>
                        <h4 class="fw-bold text-dark mb-2">Belum ada tugas</h4>
                        <p class="mb-0 fs-6">Tidak ada tugas yang di-assign kepada Anda saat ini</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($tasks->hasPages())
            <div class="d-flex justify-content-center mt-4">
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
        @endif

    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4"
                    style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Update Status Tugas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-question-circle text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Update Status Tugas?</h6>
                    <p class="text-muted mb-0">Tugas: <strong id="updateTaskTitle"></strong></p>
                    <p class="text-muted small">Status akan diubah menjadi: <strong id="updateNewStatus"></strong></p>
                </div>
                <div class="modal-footer border-0 p-4 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-3 me-2" data-bs-dismiss="modal">Batal</button>
                    <form action="" method="POST" id="updateStatusForm" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" id="updateStatusValue">
                        <button type="submit" class="btn btn-primary rounded-3">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function setUpdateForm(id, status, title) {
        document.getElementById('updateStatusForm').action = `/operator/tasks/${id}/status`;
        document.getElementById('updateStatusValue').value = status;
        document.getElementById('updateTaskTitle').textContent = title;
        document.getElementById('updateNewStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    }
</script>
@endpush