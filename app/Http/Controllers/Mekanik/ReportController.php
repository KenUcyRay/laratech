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
        $tab = $request->get('tab', 'pending'); // pending, my_processing

        $query = Report::with(['equipment', 'reporter', 'task', 'processor']);

        if ($tab == 'my_processing') {
            $query->where('status', 'processing')
                ->where('processed_by', Auth::id());

        } else {
            // Default: Pending reports (all)
            $query->where('status', 'pending');
        }


        // Filter severity
        if ($request->has('severity')) {
            $query->where('severity', $request->severity);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(10);

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
            // Use report description as title (truncated) or specific title
            $title = $validated['task_title'] ?? \Illuminate\Support\Str::limit($report->description, 20, '...');

            $task = Task::create([
                'equipment_id' => $report->equipment_id,
                'title' => $title,
                'priority' => $report->severity === 'high' ? 'high' : 'medium',
                'status' => 'todo',
                'assigned_to' => Auth::id(),
                'due_date' => now()->addDays(3),
            ]);

            $report->task_id = $task->id;
            $report->status = 'processing'; // Auto update status
            $report->processed_by = Auth::id(); // Assign to current user
        }

        // Manual status update
        if ($request->has('status')) {
            $report->status = $validated['status'];

            // If status becomes processing, assign to current user if not set
            if ($validated['status'] == 'processing') {
                $report->processed_by = Auth::id();
            }
        }

        $report->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Report berhasil diperbarui',
            'data' => $report->load('task')
        ]);
    }
}
