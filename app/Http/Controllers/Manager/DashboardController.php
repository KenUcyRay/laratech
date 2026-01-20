<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Report;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::whereIn('status', ['todo', 'doing'])->count();
        $completedTasks = Task::where('status', 'done')->count();
        
        $totalOperators = User::where('role', 'operator')->count();
        $totalMekaniks = User::where('role', 'mekanik')->count();
        
        $equipmentStatus = [
            'idle' => Equipment::where('status', 'idle')->count(),
            'operasi' => Equipment::where('status', 'operasi')->count(),
            'rusak' => Equipment::where('status', 'rusak')->count(),
            'servis' => Equipment::where('status', 'servis')->count(),
        ];
        
        $recentTasks = Task::with(['equipment', 'assignee'])
            ->latest()
            ->limit(5)
            ->get();
            
        $criticalReports = Report::where('severity', 'high')
            ->with(['equipment', 'reporter'])
            ->latest()
            ->limit(5)
            ->get();

        return view('manager.dashboard', compact(
            'totalTasks',
            'pendingTasks', 
            'completedTasks',
            'totalOperators',
            'totalMekaniks',
            'equipmentStatus',
            'recentTasks',
            'criticalReports'
        ));
    }
}