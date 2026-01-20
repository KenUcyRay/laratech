<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::with(['equipment', 'reporter', 'task'])
            ->orderBy('created_at', 'desc');

        // Filter severity
        if ($request->has('severity')) {
            $query->where('severity', $request->severity);
        }

        // Filter status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->get();

        return view('mekanik.reports.index', compact('reports'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|in:pending,processing,resolved',
            'action' => 'nullable|string', // Support 'assign_task' from JS
            'task_title' => 'nullable|string'
        ]);

        // Assign to task checks
        if ($request->boolean('assign_to_task') || $request->input('action') === 'assign_task') {
            // Create a new task linked
            $task = Task::create([
                'equipment_id' => $report->equipment_id,
                'title' => $validated['task_title'] ?? 'Perbaikan dari Report #' . $report->id,
                'priority' => $report->severity === 'high' ? 'high' : 'medium',
                'status' => 'todo',
                'assigned_to' => Auth::id(),
                'due_date' => now()->addDays(3),
            ]);

            $report->task_id = $task->id;
            $report->status = 'processing'; // Auto update status
        }

        // Manual status update
        if ($request->has('status')) {
            $report->status = $validated['status'];
        }

        $report->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Report berhasil diperbarui',
            'data' => $report->load('task')
        ]);
    }
}
