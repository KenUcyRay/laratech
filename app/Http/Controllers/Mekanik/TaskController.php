<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $query = Task::with(['equipment', 'equipment.type', 'report'])
            ->where('assigned_to', auth()->id())
            ->whereIn('status', ['todo', 'doing'])
            ->orderByRaw("FIELD(status, 'doing', 'todo')") // Show 'doing' first, then 'todo'
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc');

        $pageTitle = 'My Tasks';

        $tasks = $query->paginate(10);

        return view('mekanik.tasks.index', compact('tasks', 'pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:todo,doing,done,cancelled',
        ]);

        $data = ['status' => $validated['status']];

        if ($validated['status'] === 'doing' && $task->status !== 'doing') {
            $data['started_at'] = now();

            if ($task->equipment) {
                $task->equipment->update(['status' => 'servis']);
            }
        }

        if ($validated['status'] === 'done' && $task->status !== 'done') {
            $data['completed_at'] = now();

            $report = \App\Models\Report::where('task_id', $task->id)->first();
            if ($report) {
                $report->update(['status' => 'resolved']);
            }

            if ($task->equipment) {
                $task->equipment->update(['status' => 'idle']);
            }
        }

        $task->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Status task berhasil diperbarui',
            'data' => $task
        ]);
    }
}
