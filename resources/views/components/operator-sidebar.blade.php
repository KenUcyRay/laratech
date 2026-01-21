@section('sidebar')
<div class="h-100 pt-0" 
     style="background: linear-gradient(180deg, #10B981 0%, #059669 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;">

    <!-- Sidebar Header -->
    <div class="p-4 border-bottom border-white border-opacity-25">
        <div class="d-flex align-items-center text-white mb-4">
            <i class="fas fa-desktop fs-3 me-3" style="color: rgba(255,255,255,0.95);"></i>
            <div>
                <h5 class="mb-0 fw-bold">Operator Panel</h5>
                <small class="opacity-75">LaraTech System</small>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="nav flex-column gap-2">
            @php
                $links = [
                    ['route'=>'operator.dashboard', 'icon'=>'fa-chart-line', 'title'=>'Dashboard', 'subtitle'=>'Overview & statistik'],
                    ['route'=>'operator.tasks.index', 'icon'=>'fa-tasks', 'title'=>'Tugas Saya', 'subtitle'=>'Kelola tugas harian'],
                    ['route'=>'operator.schedules.index', 'icon'=>'fa-calendar-alt', 'title'=>'Jadwal Kerja', 'subtitle'=>'Atur waktu kerja'],
                    ['route'=>'operator.equipment.index', 'icon'=>'fa-cogs', 'title'=>'Equipment', 'subtitle'=>'Lihat list & detail equipment'],
                    ['route'=>'operator.reports.index', 'icon'=>'fa-exclamation-triangle', 'title'=>'Laporan Harian', 'subtitle'=>'Buat & lihat laporan'],
                    ['route'=>'operator.maintenance.index', 'icon'=>'fa-tools', 'title'=>'Maintenance', 'subtitle'=>'Perawatan sistem'],
                ];
            @endphp

            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="nav-link d-flex align-items-center p-3 rounded-3 text-decoration-none"
                   style="
                      transition: all 0.3s ease;
                      color: {{ request()->routeIs($link['route'].'*') ? 'white' : 'rgba(255,255,255,0.8)' }};
                      background-color: {{ request()->routeIs($link['route'].'*') ? 'rgba(255,255,255,0.15)' : 'transparent' }};
                      box-shadow: {{ request()->routeIs($link['route'].'*') ? 'inset 3px 0 0 0 rgba(255,255,255,0.9)' : 'none' }};
                   "
                   onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'; this.style.color='white'; this.querySelector('i').style.transform='scale(1.2)';"
                   onmouseout="this.style.backgroundColor='{{ request()->routeIs($link['route'].'*') ? 'rgba(255,255,255,0.15)' : 'transparent' }}'; this.style.color='{{ request()->routeIs($link['route'].'*') ? 'white' : 'rgba(255,255,255,0.8)' }}'; this.querySelector('i').style.transform='scale(1)';"
                >
                    <div class="icon-container me-3 fs-5" style="transition: transform 0.2s ease, color 0.2s ease;">
                        <i class="fas {{ $link['icon'] }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $link['title'] }}</div>
                        <small class="d-block" style="opacity: 0.75;">{{ $link['subtitle'] }}</small>
                    </div>
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mt-auto p-3 text-center text-white" style="opacity:0.5; font-size: 0.8rem;">
        &copy; {{ date('Y') }} LaraTech System
    </div>
</div>
@endsection
