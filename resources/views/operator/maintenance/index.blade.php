<h1>Jadwal Maintenance</h1>

<p><em>Informasi jadwal maintenance equipment (Read-only)</em></p>

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Equipment</th>
            <th>Tipe Jadwal</th>
            <th>Last Service</th>
            <th>Next Service</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($maintenances as $maintenance)
            <tr>
                <td>{{ $maintenance->equipment->name }} ({{ $maintenance->equipment->code }})</td>
                <td>{{ ucfirst($maintenance->schedule_type) }}</td>
                <td>{{ $maintenance->last_service ? $maintenance->last_service->format('d/m/Y') : '-' }}</td>
                <td>{{ $maintenance->next_service->format('d/m/Y') }}</td>
                <td>
                    @if($maintenance->next_service->isPast())
                        <span style="color: red;">Overdue</span>
                    @elseif($maintenance->next_service->diffInDays(now()) <= 7)
                        <span style="color: orange;">Due Soon</span>
                    @else
                        <span style="color: green;">Scheduled</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada jadwal maintenance</td>
            </tr>
        @endforelse
    </tbody>
</table>