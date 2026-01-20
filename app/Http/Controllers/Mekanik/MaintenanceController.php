<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        $maintenances = Maintenance::where('next_service', '<=', now()->addDays(14)) // Show upcoming 2 weeks
            ->with(['equipment', 'equipment.type'])
            ->orderBy('next_service', 'asc')
            ->get();

        return view('mekanik.maintenance.index', compact('maintenances'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:complete',
            'notes' => 'nullable|string'
        ]);

        if ($validated['action'] === 'complete') {
            $maintenance->update([
                'last_service' => now(),
                'next_service' => now()->addMonth(), // Default increment
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance berhasil diselesaikan',
            'data' => $maintenance
        ]);
    }
}
