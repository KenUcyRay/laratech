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
        $tasks = Task::whereIn('status', ['todo', 'doing'])
            ->with(['equipment', 'equipment.type'])
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('mekanik.tasks.index', compact('tasks'));
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
        }

        if ($validated['status'] === 'done' && $task->status !== 'done') {
            $data['completed_at'] = now();
        }

        $task->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Status task berhasil diperbarui',
            'data' => $task
        ]);
    }
}
