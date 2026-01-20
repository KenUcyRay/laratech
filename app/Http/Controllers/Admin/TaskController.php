<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['equipment', 'assignee', 'report'])->latest()->get();
        // Load data for Create Modal
        $equipments = Equipment::all();
        $assignees = User::whereIn('role', ['mekanik', 'operator'])->get(); // Adjust roles as needed

        return view('admin.tasks.index', compact('tasks', 'equipments', 'assignees'));
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

        $task = Task::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Task berhasil dibuat',
            'data' => $task
        ]);
    }

    public function show($id)
    {
        $task = Task::with(['equipment', 'assignee', 'report'])->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $task
        ]);
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

        return response()->json([
            'status' => 'success',
            'message' => 'Task berhasil diperbarui',
            'data' => $task
        ]);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task berhasil dihapus'
        ]);
    }
}
