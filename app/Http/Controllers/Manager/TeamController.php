<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

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
            ->paginate(3, ['*'], 'operators');

        $mekaniks = User::where('role', 'mekanik')
            ->withCount(['tasks as total_tasks', 'tasks as pending_tasks' => function($query) {
                $query->whereIn('status', ['todo', 'doing']);
            }, 'tasks as completed_tasks' => function($query) {
                $query->where('status', 'done');
            }])
            ->paginate(3, ['*'], 'mekaniks');

        return view('manager.team.index', compact('operators', 'mekaniks'));
    }

    public function exportPdf(): Response
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

        $pdf = Pdf::loadView('manager.team.pdf', compact('operators', 'mekaniks'));
        
        return $pdf->download('team-report-' . now()->format('Y-m-d') . '.pdf');
    }
}