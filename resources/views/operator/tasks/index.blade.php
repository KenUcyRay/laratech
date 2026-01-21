@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
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

    {{-- Task Grid / Loop dari backend --}}
    <div class="row g-4">
        @forelse($tasks as $task)
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            {{-- Badge Status --}}
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'emoji' => '🕐', 'bg' => 'rgba(255,193,7,0.1)', 'text' => 'Pending'],
                                    'in_progress' => ['color' => 'info', 'emoji' => '▶️', 'bg' => 'rgba(13,202,240,0.1)', 'text' => 'In Progress'],
                                    'completed' => ['color' => 'success', 'emoji' => '✅', 'bg' => 'rgba(25,135,84,0.1)', 'text' => 'Completed'],
                                ];
                                $statusConf = $statusConfig[$task->status] ?? $statusConfig['pending'];
                            @endphp
                            <div class="rounded-3 p-2" style="background: {{ $statusConf['bg'] }}">
                                <span class="fs-5">{{ $statusConf['emoji'] }}</span>
                            </div>

                            {{-- Dropdown Update Status --}}
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown" style="width: 32px; height: 32px;">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li><h6 class="dropdown-header">Update Status</h6></li>
                                    <li>
                                        <form action="{{ route('operator.tasks.updateStatus', $task->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="dropdown-item {{ $task->status === 'pending' ? 'active' : '' }}">
                                                <i class="fas fa-clock me-2 text-warning"></i>Pending
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('operator.tasks.updateStatus', $task->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="dropdown-item {{ $task->status === 'in_progress' ? 'active' : '' }}">
                                                <i class="fas fa-play me-2 text-info"></i>In Progress
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('operator.tasks.updateStatus', $task->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="dropdown-item {{ $task->status === 'completed' ? 'active' : '' }}">
                                                <i class="fas fa-check me-2 text-success"></i>Completed
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Task Title & Description --}}
                        <h5 class="fw-bold text-dark mb-2 py-2">{{ $task->title }}</h5>

                        {{-- Status badge + Priority badge + Deadline --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <span class="badge bg-{{ $statusConf['color'] }} bg-opacity-10 text-{{ $statusConf['color'] }} border border-{{ $statusConf['color'] }} border-opacity-25 rounded-pill px-3 py-2">
                                    {{ $statusConf['text'] }}
                                </span>
                                @php
                                    $priorityConfig = [
                                        'low' => ['color' => '', 'text' => 'Low', 'style' => 'background: rgba(108,117,125,0.1); color: #6c757d; border: 1px solid rgba(108,117,125,0.25);'],
                                        'medium' => ['color' => '', 'text' => 'Medium', 'style' => 'background: rgba(255,69,0,0.15); color: #ff4500; border: 1px solid rgba(255,69,0,0.4);'],
                                        'high' => ['color' => '', 'text' => 'High', 'style' => 'background: rgba(255,0,0,0.15); color: #dc143c; border: 1px solid rgba(255,0,0,0.4);'],
                                    ];
                                    $priorityConf = $priorityConfig[$task->priority] ?? $priorityConfig['low'];
                                @endphp
                                @if($priorityConf['style'])
                                    <span class="badge rounded-pill px-3 py-2" style="{{ $priorityConf['style'] }}">
                                        {{ $priorityConf['text'] }}
                                    </span>
                                @else
                                    <span class="badge bg-{{ $priorityConf['color'] }} bg-opacity-10 text-{{ $priorityConf['color'] }} border border-{{ $priorityConf['color'] }} border-opacity-25 rounded-pill px-3 py-2">
                                        {{ $priorityConf['text'] }}
                                    </span>
                                @endif
                            </div>
                            @if($task->due_date)
                                <small class="text-muted d-flex align-items-center"><i class="fas fa-calendar-alt me-1"></i>{{ $task->due_date->format('d/m/Y H:i') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="col-12 text-center py-5">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h4 class="fw-bold text-dark mb-2">Belum ada tugas</h4>
                <p class="text-muted mb-0 fs-6">Tidak ada tugas yang di-assign kepada Anda saat ini</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
