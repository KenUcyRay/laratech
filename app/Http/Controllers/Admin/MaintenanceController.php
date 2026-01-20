<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with(['equipment', 'assignee'])->orderBy('next_service_due', 'asc')->get();
        // For Create Modal
        $equipments = Equipment::all();
        $assignees = User::whereIn('role', ['mekanik', 'operator'])->get();

        return view('admin.maintenance.index', compact('maintenances', 'equipments', 'assignees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'user_id' => 'required|exists:users,id',
            'last_service_date' => 'nullable|date',
        ]);

        $lastService = $validated['last_service_date'] ? \Carbon\Carbon::parse($validated['last_service_date']) : now();
        $validated['next_service_due'] = $lastService->copy()->addHours(1500);

        $maintenance = Maintenance::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal maintenance berhasil dibuat',
            'data' => $maintenance
        ]);
    }

    public function show($id)
    {
        $maintenance = Maintenance::with(['equipment', 'assignee'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $maintenance
        ]);
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'user_id' => 'required|exists:users,id',
            'last_service_date' => 'nullable|date',
        ]);

        $lastService = $validated['last_service_date'] ? \Carbon\Carbon::parse($validated['last_service_date']) : now();
        $validated['next_service_due'] = $lastService->copy()->addHours(1500);

        $maintenance->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal maintenance berhasil diperbarui',
            'data' => $maintenance
        ]);
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal maintenance berhasil dihapus'
        ]);
    }
}
