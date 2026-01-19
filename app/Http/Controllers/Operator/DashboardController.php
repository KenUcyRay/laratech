<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $myTasks = Task::where('assigned_to', $user->id)
            ->with('equipment')
            ->latest()
            ->get();

        $taskCounts = [
            'todo' => $myTasks->where('status', 'todo')->count(),
            'doing' => $myTasks->where('status', 'doing')->count(),
            'done' => $myTasks->where('status', 'done')->count(),
            'total' => $myTasks->count(),
        ];

        $Equipment = Task::where('assigned_to', $user->id)
            ->where('status', 'doing')
            ->with('equipment.type')
            ->get()
            ->pluck('equipment')
            ->unique('id');

        return view('operator.dashboard', compact(
            'myTasks',
            'taskCounts',
            'Equipment'
        ));
    }
}
