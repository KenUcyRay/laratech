<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Maintenance;
use App\Models\Report;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        //(tasks in progress or pending)
        $activeWorkOrders = Task::whereIn('status', ['todo', 'doing'])->count();

        $completedRepairs = Task::where('status', 'done')->count();

        $scheduledMaintenance = Maintenance::where('next_service', '>', now())
            ->count();

        //(high priority tasks that are active)
        $urgentRepairs = Task::whereIn('status', ['todo', 'doing'])
            ->where('priority', 'high')
            ->count();

        //(high priority - within 7 days)
        $maintenanceDue = Maintenance::where('next_service', '<=', now()->addDays(7))
            ->with(['equipment', 'equipment.type'])
            ->orderBy('next_service', 'asc')
            ->get();

        $activeRepairTasks = Task::whereIn('status', ['todo', 'doing'])
            ->with(['equipment', 'equipment.type'])
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        $criticalReports = Report::whereIn('severity', ['medium', 'high'])
            ->with(['equipment', 'equipment.type', 'reporter', 'images'])
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $reportCount = [
            'low' => Report::where('severity', 'low')->count(),
            'medium' => Report::where('severity', 'medium')->count(),
            'high' => Report::where('severity', 'high')->count(),
        ];

        return view('mekanik.dashboard', compact(
            'activeWorkOrders',
            'completedRepairs',
            'scheduledMaintenance',
            'urgentRepairs',
            'maintenanceDue',
            'activeRepairTasks',
            'criticalReports',
            'reportCount'
        ));
    }
}
