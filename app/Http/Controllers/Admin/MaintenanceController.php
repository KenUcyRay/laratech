<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Equipment;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('equipment')->orderBy('next_service', 'asc')->get();
        // For Create Modal
        $equipments = Equipment::all();

        return view('admin.maintenance.index', compact('maintenances', 'equipments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'schedule_type' => 'required|string', // e.g., monthly, weekly, or 500-hours
            'last_service' => 'nullable|date',
            'next_service' => 'required|date|after_or_equal:today',
        ]);

        $maintenance = Maintenance::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal maintenance berhasil dibuat',
            'data' => $maintenance
        ]);
    }

    public function show($id)
    {
        $maintenance = Maintenance::with('equipment')->findOrFail($id);

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
            'schedule_type' => 'required|string',
            'last_service' => 'nullable|date',
            'next_service' => 'required|date',
        ]);

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
