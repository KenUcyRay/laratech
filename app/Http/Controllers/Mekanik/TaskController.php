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
        $query = Task::with(['equipment', 'equipment.type'])
            ->where('assigned_to', auth()->id())
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc');

        $pageTitle = 'Work Orders';
        $allowStart = false;
        $allowComplete = false;

        if (request()->routeIs('mekanik.work-orders*')) {
            $query->where('status', 'todo');
            $pageTitle = 'Work Orders (Pending)';
            $allowStart = true;
        } elseif (request()->routeIs('mekanik.repairs*')) {
            $query->whereIn('status', ['doing']);
            $pageTitle = 'Perbaikan (In Progress)';
            $allowComplete = true;
        } else {
            // Fallback or show all active
            $query->whereIn('status', ['todo', 'doing']);
        }

        $tasks = $query->paginate(10);

        return view('mekanik.tasks.index', compact('tasks', 'pageTitle', 'allowStart', 'allowComplete'));
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
