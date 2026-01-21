<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['equipment', 'assignee', 'report'])->latest()->paginate(5);
        $equipments = Equipment::all();
        $assignees = User::whereIn('role', ['mekanik', 'operator'])->get();

        return view('manager.tasks.index', compact('tasks', 'equipments', 'assignees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'equipment_id' => 'required|exists:equipments,id',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'status' => 'required|in:todo,doing,done,cancelled',
        ]);

        Task::create($validated);

        return redirect()->route('manager.tasks.index')->with('success', 'Task berhasil dibuat');
    }

    public function edit($id)
    {
        $task = Task::with(['equipment', 'assignee'])->findOrFail($id);
        $equipments = Equipment::all();
        $assignees = User::whereIn('role', ['mekanik', 'operator'])->get();
        
        return view('manager.tasks.edit', compact('task', 'equipments', 'assignees'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'equipment_id' => 'required|exists:equipments,id',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'status' => 'required|in:todo,doing,done,cancelled',
        ]);

        $task->update($validated);

        return redirect()->route('manager.tasks.index')->with('success', 'Task berhasil diperbarui');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('manager.tasks.index')->with('success', 'Task berhasil dihapus');
    }
}