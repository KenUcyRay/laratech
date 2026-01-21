<div class="row g-4 mb-4">
    {{-- Todo --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-warning fs-1">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $taskCounts['todo'] ?? 0 }}</h5>
                    <small class="text-muted">Pending Tasks</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Doing --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-info fs-1">
                    <i class="fas fa-spinner"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $taskCounts['doing'] ?? 0 }}</h5>
                    <small class="text-muted">Doing Tasks</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Tasks --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-primary fs-1">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $todayTasks ?? 0 }}</h5>
                    <small class="text-muted">Today's Tasks</small>
                </div>
            </div>
        </div>
    </div>

    {{-- My Reports --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="transition: all 0.3s ease; cursor: pointer;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-secondary fs-1">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $myReportsCount ?? 0 }}</h5>
                    <small class="text-muted">My Reports</small>
                </div>
            </div>
        </div>
    </div>
</div>