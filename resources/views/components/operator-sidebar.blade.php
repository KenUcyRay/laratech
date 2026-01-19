<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}" 
               href="{{ route('operator.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('operator.tasks*') ? 'active' : '' }}" 
               href="{{ route('operator.tasks.index') }}">
                <i class="fas fa-tasks me-2"></i>Tugas Saya
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('operator.schedules*') ? 'active' : '' }}" 
               href="{{ route('operator.schedules.index') }}">
                <i class="fas fa-calendar me-2"></i>Jadwal Kerja
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('operator.reports*') ? 'active' : '' }}" 
               href="{{ route('operator.reports.index') }}">
                <i class="fas fa-file-alt me-2"></i>Laporan Harian
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('operator.maintenance*') ? 'active' : '' }}" 
               href="{{ route('operator.maintenance.index') }}">
                <i class="fas fa-tools me-2"></i>Maintenance
            </a>
        </li>
    </ul>
</div>