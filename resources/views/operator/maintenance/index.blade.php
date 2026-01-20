@extends('layouts.app')

@section('title', 'Maintenance')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-tools" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="fas fa-wrench text-white fs-4"></i>
                        </div>
                        <h1 class="fw-bold mb-0 text-white">Jadwal Maintenance</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        🔧 Informasi jadwal maintenance equipment
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Maintenance Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Equipment</th>
                            <th class="fw-semibold">Tipe Jadwal</th>
                            <th class="fw-semibold">Last Service</th>
                            <th class="fw-semibold">Next Service</th>
                            <th class="fw-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances ?? [] as $maintenance)
                            <tr>
                                <td class="fw-medium">{{ $maintenance->equipment->name ?? 'Equipment A' }} ({{ $maintenance->equipment->code ?? 'EQ001' }})</td>
                                <td>{{ ucfirst($maintenance->schedule_type ?? 'monthly') }}</td>
                                <td>{{ $maintenance->last_service ? $maintenance->last_service->format('d/m/Y') : '15/12/2024' }}</td>
                                <td>{{ $maintenance->next_service ? $maintenance->next_service->format('d/m/Y') : '15/01/2025' }}</td>
                                <td>
                                    @php
                                        $status = 'scheduled';
                                        if(isset($maintenance->next_service)) {
                                            if($maintenance->next_service->isPast()) $status = 'overdue';
                                            elseif($maintenance->next_service->diffInDays(now()) <= 7) $status = 'due_soon';
                                        }
                                    @endphp
                                    @if($status === 'overdue')
                                        <span class="badge bg-danger">Overdue</span>
                                    @elseif($status === 'due_soon')
                                        <span class="badge bg-warning">Due Soon</span>
                                    @else
                                        <span class="badge bg-success">Scheduled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-tools fs-3 mb-2"></i>
                                        <p class="mb-0">Tidak ada jadwal maintenance</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection