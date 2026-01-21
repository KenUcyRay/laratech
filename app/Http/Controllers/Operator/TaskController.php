<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $tasks = Task::where('assigned_to', $user->id)
            ->with(['equipment.type'])
            ->latest()
            ->paginate(10);

        return view('operator.tasks.index', compact('tasks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'],
            'assigned_to' => Auth::id(),
            'status' => 'todo',
            'equipment_id' => null, // Set null untuk task umum
        ]);

        return redirect()->route('operator.tasks.index')->with('success', 'Task berhasil dibuat.');
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $user = Auth::user();

        $task = Task::where('assigned_to', $user->id)->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,in_progress,completed'],
        ]);

        $data = ['status' => $validated['status']];

        // Auto-set timestamps
        if ($validated['status'] === 'in_progress' && is_null($task->started_at)) {
            $data['started_at'] = now();
        }

        if ($validated['status'] === 'completed' && is_null($task->completed_at)) {
            $data['completed_at'] = now();
        }

        $task->update($data);

        return redirect()->route('operator.tasks.index')->with('success', 'Status task berhasil diupdate.');
    }
}
