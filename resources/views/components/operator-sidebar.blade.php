<div class="position-sticky pt-4">
    <div class="bg-white rounded-4 shadow-sm p-3 mb-4">
        <div class="text-center mb-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                <i class="fas fa-user-cog fs-3 text-primary"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Operator Panel</h6>
            <small class="text-muted">Kelola operasional harian</small>
        </div>
        
        <nav class="nav flex-column gap-2">
            <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.dashboard') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.dashboard') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <div class="fw-semibold">Dashboard</div>
                    <small class="text-muted">Overview & statistik</small>
                </div>
            </a>
            
            <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.tasks*') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.tasks.index') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <div class="fw-semibold">Tugas Saya</div>
                    <small class="text-muted">Kelola tugas harian</small>
                </div>
            </a>
            
            <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.schedules*') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.schedules.index') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <div class="fw-semibold">Jadwal Kerja</div>
                    <small class="text-muted">Atur waktu kerja</small>
                </div>
            </a>
            
            <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.reports*') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.reports.index') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-file-chart-line"></i>
                </div>
                <div>
                    <div class="fw-semibold">Laporan Harian</div>
                    <small class="text-muted">Buat & lihat laporan</small>
                </div>
            </a>
            
            <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.maintenance*') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.maintenance.index') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-tools"></i>
                </div>
                <div>
                    <div class="fw-semibold">Maintenance</div>
                    <small class="text-muted">Perawatan sistem</small>
                </div>
            </a>
        </nav>
    </div>
</div>

<style>
.nav-modern {
    color: #6c757d !important;
    background: transparent;
    border: 1px solid transparent;
}

.nav-modern:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(29, 78, 216, 0.1) 100%) !important;
    color: #495057 !important;
    transform: translateX(5px);
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.active-modern {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    transform: translateX(5px);
}

.icon-container {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.active-modern .icon-container {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.nav-modern .icon-container {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

.nav-modern:hover .icon-container {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}
</style>