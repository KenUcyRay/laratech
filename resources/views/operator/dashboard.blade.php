@extends('layouts.app')

@section('title', 'Operator Dashboard')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">

        <div class="mb-5">
            <div class="bg-dark rounded p-4 mb-4 shadow text-center"
                style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                <div class="d-flex align-items-center justify-content-center">
                    <div>
                        <h2 class="text-white fw-bold mb-1">Dashboard Operator</h2>
                        <p class="text-white-50 mb-0">
                            Pantau dan kelola aktivitas operasional hari ini
                        </p>
                    </div>
                </div>
            </div>
        </div>


        @include('operator.partials.summary-cards')

        {{-- Visualization --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">📊 Status Pekerjaan</h5>

                        @php
                            $total = $taskCounts['total'] > 0 ? $taskCounts['total'] : 1;
                            $todoPct = ($taskCounts['todo'] / $total) * 100;
                            $doingPct = ($taskCounts['doing'] / $total) * 100;
                            $donePct = ($taskCounts['done'] / $total) * 100;
                        @endphp

                        <div class="progress" style="height: 30px; border-radius: 15px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $todoPct }}%"
                                aria-valuenow="{{ $todoPct }}" aria-valuemin="0" aria-valuemax="100"
                                data-bs-toggle="tooltip" title="Todo: {{ $taskCounts['todo'] }}">
                                @if($taskCounts['todo'] > 0) {{ $taskCounts['todo'] }} @endif
                            </div>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $doingPct }}%"
                                aria-valuenow="{{ $doingPct }}" aria-valuemin="0" aria-valuemax="100"
                                data-bs-toggle="tooltip" title="Doing: {{ $taskCounts['doing'] }}">
                                @if($taskCounts['doing'] > 0) {{ $taskCounts['doing'] }} @endif
                            </div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $donePct }}%"
                                aria-valuenow="{{ $donePct }}" aria-valuemin="0" aria-valuemax="100"
                                data-bs-toggle="tooltip" title="Selesai: {{ $taskCounts['done'] }}">
                                @if($taskCounts['done'] > 0) {{ $taskCounts['done'] }} @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2 text-muted small">
                            <span><i class="fas fa-circle text-warning me-1"></i> Todo ({{ $taskCounts['todo'] }})</span>
                            <span><i class="fas fa-circle text-primary me-1"></i> Sedang Dikerjakan
                                ({{ $taskCounts['doing'] }})</span>
                            <span><i class="fas fa-circle text-success me-1"></i> Selesai ({{ $taskCounts['done'] }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection