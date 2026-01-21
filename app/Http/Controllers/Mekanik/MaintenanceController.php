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
        // Show upcoming maintenance
        $maintenances = Maintenance::with(['equipment', 'assignee'])
            ->where('user_id', auth()->id())
            ->orderBy('next_service_due', 'asc')
            ->paginate(10);

        return view('mekanik.maintenance.index', compact('maintenances'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:complete',
            'notes' => 'nullable|string',
        ]);

        if ($validated['action'] === 'complete') {
            $maintenance->update([
                'last_service_date' => now(),
                'next_service_due' => now()->addHours(1500), // Real-time 1500 hours
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance berhasil diselesaikan',
            'data' => $maintenance
        ]);
    }
}
