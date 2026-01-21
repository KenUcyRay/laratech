<div class="h-100" style="background: linear-gradient(180deg, #111827 0%, #374151 100%); box-shadow: 2px 0 10px rgba(0,0,0,0.1); height: 100vh; overflow-y: auto; padding-top: 80px;">
    <!-- Sidebar Header -->
    <div class="p-4 border-bottom border-white border-opacity-25">
        <div class="d-flex align-items-center text-white">
            <i class="fas fa-user-tie fs-4 me-3" style="color: rgba(255,255,255,0.9);"></i>
            <div>
                <h6 class="mb-0 fw-bold">Manager Panel</h6>
                <small class="opacity-75">LaraTech System</small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="p-3">
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                    href="{{ route('manager.dashboard') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('manager.dashboard') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
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
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('manager.tasks*') ? 'active' : '' }}"
                    href="{{ route('manager.tasks.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('manager.tasks*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <span class="fw-medium">Task Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('manager.team*') ? 'active' : '' }}"
                    href="{{ route('manager.team.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('manager.team*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="fw-medium">Team Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center py-3 px-3 rounded-3 {{ request()->routeIs('manager.reports*') ? 'active' : '' }}"
                    href="{{ route('manager.reports.index') }}"
                    style="transition: all 0.3s ease; {{ request()->routeIs('manager.reports*') ? 'background: rgba(255,255,255,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.15);' : '' }}"
                    onmouseover="if(!this.classList.contains('active')) this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="if(!this.classList.contains('active')) this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-2 me-3"
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.15);">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    <span class="fw-medium">Reports</span>
                </a>
            </li>
        </ul>
    </div>
</div>