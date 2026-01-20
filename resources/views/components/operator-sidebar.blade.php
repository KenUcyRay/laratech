<div class="h-100 pt-0" style="background: linear-gradient(180deg, #10B981 0%, #059669 100%); box-shadow: 2px 0 10px rgba(0,0,0,0.1); height: 100vh; overflow-y: auto;">
    <!-- Sidebar Header -->
    <div class="p-4 border-bottom border-white border-opacity-25">
        <div class="d-flex align-items-center text-white">
            <i class="fas fa-desktop fs-4 me-3" style="color: rgba(255,255,255,0.9);"></i>
            <div>
                <h6 class="mb-0 fw-bold">Operator Panel</h6>
                <small class="opacity-75">LaraTech System</small>
            </div>
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

             <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.equipment*') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.equipment.index') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-cogs"></i>
                </div>
                <div>
                    <div class="fw-semibold">Equipment</div>
                    <small class="text-muted">Lihat list & detail equipment</small>
                </div>
            </a>
            
            <a class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none {{ request()->routeIs('operator.reports*') ? 'active-modern' : 'nav-modern' }}" 
               href="{{ route('operator.reports.index') }}" style="transition: all 0.3s ease;">
                <div class="icon-container me-3">
                    <i class="fas fa-exclamation-triangle"></i>
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

    <!-- Navigation Menu -->
    <div class="p-3">
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}" 
                   href="{{ route('operator.dashboard') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('operator.dashboard') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span class="fw-medium">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('operator.tasks*') ? 'active' : '' }}" 
                   href="{{ route('operator.tasks.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('operator.tasks*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <span class="fw-medium">Tugas Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('operator.schedules*') ? 'active' : '' }}" 
                   href="{{ route('operator.schedules.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('operator.schedules*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <span class="fw-medium">Jadwal Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('operator.reports*') ? 'active' : '' }}" 
                   href="{{ route('operator.reports.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('operator.reports*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="fw-medium">Laporan Harian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('operator.maintenance*') ? 'active' : '' }}" 
                   href="{{ route('operator.maintenance.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('operator.maintenance*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span class="fw-medium">Maintenance</span>
                </a>
            </li>
        </ul>
    </div>
</div>