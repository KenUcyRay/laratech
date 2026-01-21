@extends('layouts.app')

@section('title', 'Reports')

@section('sidebar')
    @include('components.manager-sidebar')
@endsection

@section('content')
<div class="container-fluid mt-4">

    {{-- Ultra Modern Header --}}
    <div class="position-relative overflow-hidden rounded-4 shadow-lg mb-4" style="background: linear-gradient(135deg, #111827 0%, #374151 100%);">
        <div class="position-absolute top-0 end-0 opacity-25">
            <i class="fas fa-chart-area" style="font-size: 8rem; color: white; transform: rotate(15deg); margin: -2rem;"></i>
        </div>
        <div class="p-5 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <h1 class="fw-bold mb-0 text-white">Reports</h1>
                    </div>
                    <p class="text-white-50 mb-0 fs-6">
                        📈 Analisis laporan dan monitoring sistem
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-light btn-lg rounded-3 shadow-sm">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #3b82f6 0%, #1d4ed8 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-file-alt fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['total'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Total Reports</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #ef4444 0%, #dc2626 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['high'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">High Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['medium'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Medium Priority</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #06b6d4 0%, #0891b2 100%); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-info fs-3 text-white"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1">{{ $reportStats['low'] }}</h3>
                    <p class="text-white text-opacity-75 mb-0">Low Priority</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-gray-800">📄 All Reports</h5>
                <span class="badge bg-primary rounded-pill fs-6">{{ $reports->count() }} reports</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 py-3">Equipment</th>
                            <th class="fw-semibold border-0 py-3">Reporter</th>
                            <th class="fw-semibold border-0 py-3">Description</th>
                            <th class="fw-semibold border-0 py-3">Severity</th>
                            <th class="fw-semibold border-0 py-3">Status</th>
                            <th class="fw-semibold border-0 py-3">Date</th>
                            <th class="fw-semibold border-0 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr class="border-0">
                            <td class="fw-medium py-3">{{ $report->equipment->name ?? 'N/A' }}</td>
                            <td class="py-3">{{ $report->reporter->name ?? 'N/A' }}</td>
                            <td class="py-3">{{ Str::limit($report->description, 50) }}</td>
                            <td class="py-3">
                                @if($report->severity == 'high')
                                    <span class="badge bg-danger rounded-pill px-3 py-2">High</span>
                                @elseif($report->severity == 'medium')
                                    <span class="badge bg-warning rounded-pill px-3 py-2">Medium</span>
                                @else
                                    <span class="badge bg-info rounded-pill px-3 py-2">Low</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-secondary rounded-pill px-3 py-2">{{ ucfirst($report->status) }}</span>
                            </td>
                            <td class="py-3">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-3">
                                <a href="{{ route('manager.reports.show', $report->id) }}" class="btn btn-sm btn-info rounded-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection