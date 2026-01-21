@extends('layouts.app')

@section('title', 'Team Management')

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

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-users" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Team Management</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        👥 Monitor performa dan kelola anggota tim
                    </p>
                </div>
                <div>
                    <a href="{{ route('manager.team.export.pdf') }}" class="btn btn-light btn-lg rounded-3 shadow-sm">
                        <i class="fas fa-download me-2"></i>Export to PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Team Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-6 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #10b981 0%, #059669 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-desktop fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $operators->count() }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Operators</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-wrench fs-3 text-black"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $mekaniks->count() }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Mekaniks</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Operators Section --}}
    <div class="card border-0 shadow-lg rounded-4 mb-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">🖥️ Operators</h5>
                <span class="badge bg-success rounded-pill fs-6">{{ $operators->count() }} members</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 py-3">Name</th>
                            <th class="fw-semibold border-0 py-3">Username</th>
                            <th class="fw-semibold border-0 py-3">Total Tasks</th>
                            <th class="fw-semibold border-0 py-3">Pending Tasks</th>
                            <th class="fw-semibold border-0 py-3">Completed Tasks</th>
                            <th class="fw-semibold border-0 py-3">Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($operators as $operator)
                        <tr class="border-0">
                            <td class="fw-medium py-3">{{ $operator->name }}</td>
                            <td class="py-3">{{ $operator->username }}</td>
                            <td class="py-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $operator->total_tasks }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-warning rounded-pill px-3 py-2">{{ $operator->pending_tasks }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success rounded-pill px-3 py-2">{{ $operator->completed_tasks }}</span>
                            </td>
                            <td class="py-3">
                                @php
                                    $performance = $operator->total_tasks > 0 ? 
                                        round(($operator->completed_tasks / $operator->total_tasks) * 100) : 0;
                                @endphp
                                <div class="progress rounded-pill shadow-sm" style="height: 25px; width: 120px;">
                                    <div class="progress-bar rounded-pill fw-semibold
                                        @if($performance >= 80) bg-success 
                                        @elseif($performance >= 60) bg-warning 
                                        @else bg-danger @endif" 
                                        style="width: {{ $performance }}%">
                                        {{ $performance }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Operators Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $operators->firstItem() ?? 1 }} to {{ $operators->lastItem() ?? $operators->count() }} of {{ $operators->total() }} results
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($operators->onFirstPage())
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $operators->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif
                    
                    <span class="text-muted small mx-2">
                        Page {{ $operators->currentPage() }} of {{ $operators->lastPage() }}
                    </span>
                    
                    @if ($operators->hasMorePages())
                        <a href="{{ $operators->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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

    {{-- Mekaniks Section --}}
    <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">🔧 Mekaniks</h5>
                <span class="badge bg-warning rounded-pill fs-6">{{ $mekaniks->count() }} members</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 py-3">Name</th>
                            <th class="fw-semibold border-0 py-3">Username</th>
                            <th class="fw-semibold border-0 py-3">Total Tasks</th>
                            <th class="fw-semibold border-0 py-3">Pending Tasks</th>
                            <th class="fw-semibold border-0 py-3">Completed Tasks</th>
                            <th class="fw-semibold border-0 py-3">Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mekaniks as $mekanik)
                        <tr class="border-0">
                            <td class="fw-medium py-3">{{ $mekanik->name }}</td>
                            <td class="py-3">{{ $mekanik->username }}</td>
                            <td class="py-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $mekanik->total_tasks }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-warning rounded-pill px-3 py-2">{{ $mekanik->pending_tasks }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success rounded-pill px-3 py-2">{{ $mekanik->completed_tasks }}</span>
                            </td>
                            <td class="py-3">
                                @php
                                    $performance = $mekanik->total_tasks > 0 ? 
                                        round(($mekanik->completed_tasks / $mekanik->total_tasks) * 100) : 0;
                                @endphp
                                <div class="progress rounded-pill shadow-sm" style="height: 25px; width: 120px;">
                                    <div class="progress-bar rounded-pill fw-semibold
                                        @if($performance >= 80) bg-success 
                                        @elseif($performance >= 60) bg-warning 
                                        @else bg-danger @endif" 
                                        style="width: {{ $performance }}%">
                                        {{ $performance }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Mekaniks Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $mekaniks->firstItem() ?? 1 }} to {{ $mekaniks->lastItem() ?? $mekaniks->count() }} of {{ $mekaniks->total() }} results
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($mekaniks->onFirstPage())
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $mekaniks->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif
                    
                    <span class="text-muted small mx-2">
                        Page {{ $mekaniks->currentPage() }} of {{ $mekaniks->lastPage() }}
                    </span>
                    
                    @if ($mekaniks->hasMorePages())
                        <a href="{{ $mekaniks->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
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
@endsection