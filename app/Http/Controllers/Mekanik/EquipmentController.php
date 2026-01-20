<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index(): View
    {
        $equipments = Equipment::with('type')
            ->orderBy('name')
            ->get();

        return view('mekanik.equipment.index', compact('equipments'));
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:idle,operasi,rusak,servis',
        ]);

        $oldStatus = $equipment->status;
        $equipment->update(['status' => $validated['status']]);

        // Trigger logic if status = 'rusak'
        $newTask = null;
        if ($validated['status'] === 'rusak' && $oldStatus !== 'rusak') {
            // Auto-create high priority repair task
            $newTask = Task::create([
                'equipment_id' => $equipment->id,
                'title' => 'Perbaikan Darurat: ' . $equipment->name,
                'priority' => 'high',
                'status' => 'todo',
                'due_date' => now()->addDays(1), // Due tomorrow
                'assigned_to' => Auth::id(), // self asigned
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Status equipment berhasil diperbarui',
            'data' => [
                'equipment' => $equipment,
                'triggered_task' => $newTask
            ]
        ]);
    }
}
