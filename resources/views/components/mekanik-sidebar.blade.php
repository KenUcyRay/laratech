<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('mekanik.dashboard') ? 'active' : '' }}" 
               href="{{ route('mekanik.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('mekanik.work-orders*') ? 'active' : '' }}" 
               href="{{ route('mekanik.work-orders.index') }}">
                <i class="fas fa-clipboard-list me-2"></i>Work Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('mekanik.maintenance*') ? 'active' : '' }}" 
               href="{{ route('mekanik.maintenance.index') }}">
                <i class="fas fa-wrench me-2"></i>Maintenance
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('mekanik.repairs*') ? 'active' : '' }}" 
               href="{{ route('mekanik.repairs.index') }}">
                <i class="fas fa-tools me-2"></i>Perbaikan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('mekanik.inventory*') ? 'active' : '' }}" 
               href="{{ route('mekanik.inventory.index') }}">
                <i class="fas fa-boxes me-2"></i>Inventori Spare Part
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('mekanik.reports*') ? 'active' : '' }}" 
               href="{{ route('mekanik.reports.index') }}">
                <i class="fas fa-file-alt me-2"></i>Laporan Kerja
            </a>
        </li>
    </ul>
</div>