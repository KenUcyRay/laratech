@extends('layouts.app')

@section('title', 'Maintenance Schedule')

@section('sidebar')
    @include('components.mekanik-sidebar')
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Ultra Modern Header --}}
        <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4"
            style="background: linear-gradient(135deg, #B6771D 0%, #7B542F 100%);">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="fas fa-wrench"
                    style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
            </div>
            <div class="p-5 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold mb-0 text-white">Maintenance Schedule</h1>
                        </div>
                        <p class="text-white-50 mb-0 fs-6">
                            🔧 Equipment maintenance and service schedule
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Maintenance Table --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($maintenances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="20%">Equipment</th>
                                    <th width="15%">Assignee</th>
                                    <th width="15%">Last Service Date</th>
                                    <th width="15%">Next Service Due</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenances as $m)
                                    <tr id="row-{{ $m->id }}">
                                        <td>{{ $m->equipment->name ?? '-' }}</td>
                                        <td>{{ $m->assignee->name ?? '-' }}</td>
                                        <td>{{ $m->last_service_date ? $m->last_service_date->format('Y-m-d H:i') : '-' }}</td>
                                        <td>
                                            {{ $m->next_service_due ? $m->next_service_due->format('Y-m-d H:i') : '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $isDue = now()->greaterThanOrEqualTo($m->next_service_due);
                                                $isClose = now()->addDays(2)->greaterThanOrEqualTo($m->next_service_due);
                                            @endphp
                                            <span class="badge bg-{{ $isDue ? 'danger' : ($isClose ? 'warning' : 'success') }}">
                                                {{ $isDue ? 'Overdue' : ($isClose ? 'Upcoming' : 'OK') }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success complete-btn" data-id="{{ $m->id }}">
                                                <i class="fas fa-check-double"></i> Complete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    {{ $maintenances->links('custom.mekanik-pagination') }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Scheduled Maintenance</h5>
                        <p class="text-muted">There are currently no maintenance schedules to display.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.complete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    let id = this.dataset.id;

                    // Direct completion without modal
                    if (!confirm('Are you sure you want to mark this scheduled maintenance as complete?')) return;

                    fetch(`/mekanik/maintenance/${id}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            action: 'complete',
                            notes: '' // Empty notes as per requirement
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        });
                });
            });
        </script>
    @endpush
@endsection