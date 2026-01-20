<div class="h-100 position-sticky pt-0"
    style="background: linear-gradient(180deg, #ca8a04 0%, #eab308 100%); box-shadow: 2px 0 10px rgba(0,0,0,0.1);">
    <!-- Sidebar Header -->
    <div class="p-4 border-bottom border-white border-opacity-25">
    </div>

    <!-- Navigation Menu -->
    <div class="p-3">
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.dashboard') ? 'active' : '' }}"
                    href="{{ route('mekanik.dashboard') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.dashboard') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
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
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.work-orders*') ? 'active' : '' }}"
                    href="{{ route('mekanik.work-orders.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.work-orders*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <span class="fw-medium">Work Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.repairs*') ? 'active' : '' }}"
                    href="{{ route('mekanik.repairs.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.repairs*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span class="fw-medium">Perbaikan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.maintenance*') ? 'active' : '' }}"
                    href="{{ route('mekanik.maintenance.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.maintenance*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span class="fw-medium">Maintenance</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.schedules*') ? 'active' : '' }}"
                    href="{{ route('mekanik.schedules.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.schedules*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span class="fw-medium">Jadwal Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.inventory*') ? 'active' : '' }}"
                    href="{{ route('mekanik.inventory.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.inventory*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <span class="fw-medium">Inventori</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('mekanik.reports*') ? 'active' : '' }}"
                    href="{{ route('mekanik.reports.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('mekanik.reports*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="fw-medium">Laporan</span>
                </a>
            </li>
        </ul>
    </div>
</div>