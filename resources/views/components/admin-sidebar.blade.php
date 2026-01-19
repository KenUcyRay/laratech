<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
               href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
               href="{{ route('admin.users.index') }}">
                <i class="fas fa-users me-2"></i>Manajemen User
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.operators*') ? 'active' : '' }}" 
               href="{{ route('admin.operators.index') }}">
                <i class="fas fa-desktop me-2"></i>Data Operator
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.mekaniks*') ? 'active' : '' }}" 
               href="{{ route('admin.mekaniks.index') }}">
                <i class="fas fa-wrench me-2"></i>Data Mekanik
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" 
               href="{{ route('admin.reports.index') }}">
                <i class="fas fa-chart-bar me-2"></i>Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" 
               href="{{ route('admin.settings.index') }}">
                <i class="fas fa-cog me-2"></i>Pengaturan
            </a>
        </li>
    </ul>
</div>