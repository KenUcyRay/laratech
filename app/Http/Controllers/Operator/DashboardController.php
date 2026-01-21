<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $myTasks = Task::where('assigned_to', $user->id)
            ->with('equipment')
            ->latest()
            ->get();

        $todayTasks = Task::where('assigned_to', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $completedTasks = $myTasks->where('status', 'done')->count();

        // (todo)
        $pendingTasks = $myTasks->where('status', 'todo')->count();

        // total tasks
        $totalTasks = $myTasks->count();

        // semua maintenance with equipment
        $maintenance = Maintenance::with(['equipment.type'])->get();

        // working hours
        $workingMinutes = $myTasks->where('status', 'done')
            ->whereNotNull('started_at')
            ->whereNotNull('completed_at')
            ->sum(function ($task) {
                return Carbon::parse($task->started_at)
                    ->diffInMinutes(Carbon::parse($task->completed_at));
            });

        $hours = floor($workingMinutes / 60);
        $minutes = $workingMinutes % 60;
        $workingHours = "{$hours}h {$minutes}m";

        $taskCounts = [
            'todo' => $myTasks->where('status', 'todo')->count(),
            'doing' => $myTasks->where('status', 'doing')->count(),
            'done' => $myTasks->where('status', 'done')->count(),
            'cancelled' => $myTasks->where('status', 'cancelled')->count(),
            'total' => $myTasks->count(),
        ];

        // Specific vars for view backward compatibility or cleaner access
        $todoTasks = $taskCounts['todo'];
        $doingTasks = $taskCounts['doing'];
        $doneTasks = $taskCounts['done'];
        $cancelledTasks = $taskCounts['cancelled'];

        $Equipment = Task::where('assigned_to', $user->id)
            ->where('status', 'doing')
            ->with('equipment.type')
            ->get()
            ->pluck('equipment')
            ->unique('id');

        $maintenanceCount = \App\Models\Maintenance::where('user_id', $user->id)
            ->where('next_service_due', '>=', now())
            ->count();

        return view('operator.dashboard', compact(
            'myTasks',
            'todayTasks', 
            'completedTasks',
            'pendingTasks', // Kept as alias for todo
            'todoTasks',
            'doingTasks',
            'doneTasks',
            'cancelledTasks',
            'workingHours',
            'taskCounts',
            'Equipment',
            'totalTasks',
            'maintenance',
            'maintenanceCount'
        ));
    }
}
