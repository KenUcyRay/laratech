<div class="row g-4 mb-4">
    {{-- Total Tasks --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-primary fs-1">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $taskCounts['total'] ?? 0 }}</h5>
                    <small class="text-muted">Total Tugas</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Pending --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-warning fs-1">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $pendingTasks ?? 0 }}</h5>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Completed --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-success fs-1">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $completedTasks ?? 0 }}</h5>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Maintenance --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-info fs-1">
                    <i class="fas fa-tools"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $maintenanceCount ?? 0 }}</h5>
                    <small class="text-muted">Maintenance</small>
                </div>
            </div>
        </div>
    </div>
</div>