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
            ->get();

        return view('operator.tasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $user = Auth::user();

        $task = Task::where('assigned_to', $user->id)->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:todo,doing,done,cancelled'],
        ]);

        $data = ['status' => $validated['status']];

        // Auto-set timestamps
        if ($validated['status'] === 'doing' && is_null($task->started_at)) {
            $data['started_at'] = now();
        }

        if ($validated['status'] === 'done' && is_null($task->completed_at)) {
            $data['completed_at'] = now();
        }

        if ($validated['status'] === 'cancelled' && is_null($task->cancelled_at)) {
            $data['cancelled_at'] = now();
        }

        $task->update($data);

        return redirect()->route('operator.tasks.index')->with('success', 'Status task berhasil diupdate.');
    }
}
