<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Task;
use App\Models\Maintenance;
use App\Models\Report;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $activeOperators = User::where('role', 'operator')->count();
        $activeMekaniks = User::where('role', 'mekanik')->count();
        $pendingTasks = Task::whereIn('status', ['todo', 'doing'])->count();

        $totalEquipment = Equipment::count();
        $equipmentStatus = [
            'idle' => Equipment::where('status', 'idle')->count(),
            'operasi' => Equipment::where('status', 'operasi')->count(),
            'rusak' => Equipment::where('status', 'rusak')->count(),
            'servis' => Equipment::where('status', 'servis')->count(),
        ];

        $taskSummary = [
            'todo' => Task::where('status', 'todo')->count(),
            'doing' => Task::where('status', 'doing')->count(),
            'done' => Task::where('status', 'done')->count(),
            'cancelled' => Task::where('status', 'cancelled')->count(),
            'total' => Task::count(),
        ];

        // Maintenance due within 7 days
        $maintenanceDue = Maintenance::where('next_service', '<=', now()->addDays(7))
            ->with('equipment')
            ->get();

        $reportSeverity = [
            'low' => Report::where('severity', 'low')->count(),
            'medium' => Report::where('severity', 'medium')->count(),
            'high' => Report::where('severity', 'high')->count(),
            'total' => Report::count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeOperators',
            'activeMekaniks',
            'pendingTasks',
            'totalEquipment',
            'equipmentStatus',
            'taskSummary',
            'maintenanceDue',
            'reportSeverity'
        ));
    }
}
