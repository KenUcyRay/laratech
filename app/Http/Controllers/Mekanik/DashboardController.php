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
        $activeWorkOrders = Task::whereIn('status', ['todo', 'doing'])
            ->where('assigned_to', auth()->id())
            ->count();

        $completedRepairs = Task::where('status', 'done')
            ->where('assigned_to', auth()->id())
            ->count();

        // Count all active maintenance schedules
        $scheduledMaintenance = Maintenance::where('user_id', auth()->id())->count();

        //(high priority tasks that are active)
        $urgentRepairs = Task::whereIn('status', ['todo', 'doing'])
            ->where('assigned_to', auth()->id())
            ->where('priority', 'high')
            ->count();

        // Get maintenance that is due or upcoming (within 7 days)
        $maintenanceDue = Maintenance::with(['equipment', 'equipment.type', 'assignee'])
            ->where('user_id', auth()->id())
            ->where('next_service_due', '<=', now()->addDays(7))
            ->orderBy('next_service_due', 'asc')
            ->get();

        $activeRepairTasks = Task::whereIn('status', ['todo', 'doing'])
            ->where('assigned_to', auth()->id())
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
