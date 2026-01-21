@extends('layouts.app')

@section('title', 'Maintenance')

@section('sidebar')
    @include('components.operator-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">

        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-tools" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
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
                                <th class="fw-semibold">Assigne</th>
                                <th class="fw-semibold">Last Service Date</th>
                                <th class="fw-semibold">Next Service Due</th>
                                <th class="fw-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenances ?? [] as $maintenance)
                                <tr>
                                    <td class="fw-medium">{{ optional($maintenance->equipment)->name ?? 'Equipment A' }}
                                        ({{ optional($maintenance->equipment)->code ?? 'EQ001' }})</td>
                                    <td>{{ optional($maintenance->assignee)->name ?? '-' }}</td>
                                    <td>{{ $maintenance->last_service_date ? $maintenance->last_service_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $maintenance->next_service_due ? $maintenance->next_service_due->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $isDue = now()->greaterThanOrEqualTo($maintenance->next_service_due);
                                            $isClose = now()->addDays(2)->greaterThanOrEqualTo($maintenance->next_service_due);
                                        @endphp
                                        @if($isDue)
                                            <span class="badge bg-danger">Overdue</span>
                                        @elseif($isClose)
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
                
                {{-- Pagination --}}
                @if($maintenances->hasPages())
                    <div class="d-flex justify-content-end mt-4">
                        {{ $maintenances->links('custom.pagination') }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection