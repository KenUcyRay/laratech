<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        // Fetch Tasks assigned to user
        $tasks = Task::where('assigned_to', $userId)
            ->whereNotNull('due_date')
            ->whereNotIn('status', ['done', 'cancelled'])
            ->with('equipment')
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'date' => $task->due_date->format('Y-m-d'),
                    'time' => '09:00', // Default time as tasks usually have date only
                    'type' => 'task',
                    'status' => $task->status,
                    'description' => $task->description ?? 'No description',
                    'equipment' => $task->equipment ? [
                        'name' => $task->equipment->name,
                        'code' => $task->equipment->code,
                    ] : null
                ];
            });

        // Fetch Maintenance assigned to user
        $maintenances = Maintenance::where('user_id', $userId)
            ->with('equipment')
            ->get()
            ->map(function ($maintenance) {
                return [
                    'id' => $maintenance->id,
                    'title' => 'Maintenance: ' . ($maintenance->equipment->name ?? 'Unknown'),
                    'date' => $maintenance->next_service_due->format('Y-m-d'),
                    'time' => $maintenance->next_service_due->format('H:i'),
                    'type' => 'maintenance',
                    'status' => $maintenance->next_service_due->isPast() ? 'overdue' : 'scheduled',
                    'description' => 'Scheduled maintenance for ' . ($maintenance->equipment->name ?? 'Equipment'),
                    'equipment' => $maintenance->equipment ? [
                        'name' => $maintenance->equipment->name,
                        'code' => $maintenance->equipment->code,
                    ] : null
                ];
            });

        // Merge and sort by date
        $schedules = $tasks->concat($maintenances)->sortBy('date')->values();

        return view('operator.schedules.index', compact('schedules'));
    }
}
