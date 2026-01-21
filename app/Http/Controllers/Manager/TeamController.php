<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $operators = User::where('role', 'operator')
            ->withCount(['tasks as total_tasks', 'tasks as pending_tasks' => function($query) {
                $query->whereIn('status', ['todo', 'doing']);
            }, 'tasks as completed_tasks' => function($query) {
                $query->where('status', 'done');
            }])
            ->get();

        $mekaniks = User::where('role', 'mekanik')
            ->withCount(['tasks as total_tasks', 'tasks as pending_tasks' => function($query) {
                $query->whereIn('status', ['todo', 'doing']);
            }, 'tasks as completed_tasks' => function($query) {
                $query->where('status', 'done');
            }])
            ->get();

        return view('manager.team.index', compact('operators', 'mekaniks'));
    }
}