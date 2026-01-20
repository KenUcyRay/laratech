<div class="bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('manager.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cogs"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Manager</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Management</div>

    <!-- Nav Item - Tasks -->
    <li class="nav-item {{ request()->routeIs('manager.tasks.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.tasks.index') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Task Management</span>
        </a>
    </li>

    <!-- Nav Item - Team -->
    <li class="nav-item {{ request()->routeIs('manager.team.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.team.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Team Management</span>
        </a>
    </li>

    <!-- Nav Item - Reports -->
    <li class="nav-item {{ request()->routeIs('manager.reports.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.reports.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Reports</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Profile -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</div>