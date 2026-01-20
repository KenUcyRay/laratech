@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #22c55e 0%, #10b981 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-tasks" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="fas fa-clipboard-check text-white fs-4"></i>
                        </div>
                        <h1 class="fw-bold mb-0 text-white">Tugas Saya</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🚀 Kelola dan pantau progress tugas harian Anda dengan mudah
                    </p>
                </div>
                <button class="btn btn-light rounded-pill px-4 py-3 shadow" data-bs-toggle="modal" data-bs-target="#addTaskModal" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-plus me-2 text-success"></i>
                    <span class="fw-semibold text-dark">Buat Tugas</span>
                </button>
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
                            {{-- Badge Priority --}}
                            @php
                                $priorityConfig = [
                                    'low' => ['color' => 'success', 'emoji' => '🟢', 'bg' => 'rgba(25,135,84,0.1)'],
                                    'medium' => ['color' => 'warning', 'emoji' => '🟡', 'bg' => 'rgba(255,193,7,0.1)'],
                                    'high' => ['color' => 'danger', 'emoji' => '🔴', 'bg' => 'rgba(220,53,69,0.1)'],
                                ];
                                $config = $priorityConfig[$task->priority] ?? $priorityConfig['low'];
                            @endphp
                            <div class="rounded-3 p-2" style="background: {{ $config['bg'] }}">
                                <span class="fs-5">{{ $config['emoji'] }}</span>
                            </div>

                            {{-- Dropdown Update Status --}}
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown" style="width: 32px; height: 32px;">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li>
                                        <form action="{{ route('operator.tasks.updateStatus', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()" class="dropdown-item">
                                                <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>Todo</option>
                                                <option value="doing" {{ $task->status === 'doing' ? 'selected' : '' }}>Doing</option>
                                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                                <option value="cancelled" {{ $task->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Task Title & Description --}}
                        <h5 class="fw-bold text-dark mb-2">{{ $task->title }}</h5>
                        <p class="text-muted mb-3 fs-6">{{ $task->description ?? 'Tidak ada deskripsi tambahan' }}</p>

                        {{-- Priority badge + Deadline --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $config['color'] }} bg-opacity-10 text-{{ $config['color'] }} border border-{{ $config['color'] }} border-opacity-25 rounded-pill px-3 py-2">
                                {{ ucfirst($task->priority) }}
                            </span>
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
                <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
                <h4 class="fw-bold text-dark mb-2">Belum ada tugas</h4>
                <p class="text-muted mb-4 fs-6">Mulai produktivitas Anda dengan membuat tugas pertama</p>
                <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="fas fa-plus me-2"></i>Tambah Tugas Pertama
                </button>
            </div>
        @endforelse
    </div>

</div>

{{-- Modal Tambah Tugas (tetap dipisah agar rapi) --}}
@include('components.add-task-modal')

@endsection
