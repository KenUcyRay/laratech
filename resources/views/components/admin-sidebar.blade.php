<div class="h-100 pt-0" style="background: linear-gradient(180deg, #1e40af 0%, #0891b2 100%); box-shadow: 2px 0 10px rgba(0,0,0,0.1); height: 100vh; overflow-y: auto;">
    <!-- Sidebar Header -->
    <div class="p-4 border-bottom border-white border-opacity-25">
        <div class="d-flex align-items-center text-white">
            <i class="fas fa-user-shield fs-4 me-3" style="color: rgba(255,255,255,0.9);"></i>
            <div>
                <h6 class="mb-0 fw-bold">Admin Panel</h6>
                <small class="opacity-75">LaraTech System</small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="p-3">
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('admin.dashboard') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
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
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                   href="{{ route('admin.users.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('admin.users*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="fw-medium">Manajemen User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.operators*') ? 'active' : '' }}" 
                   href="{{ route('admin.operators.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('admin.operators*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <span class="fw-medium">Data Operator</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.mekaniks*') ? 'active' : '' }}" 
                   href="{{ route('admin.mekaniks.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('admin.mekaniks*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <span class="fw-medium">Data Mekanik</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" 
                   href="{{ route('admin.reports.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('admin.reports*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="fw-medium">Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings.index') }}"
                   style="transition: all 0.3s ease; {{ request()->routeIs('admin.settings*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                   onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                   onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3" 
                         style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span class="fw-medium">Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
</div>