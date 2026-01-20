<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $activeOperators = User::where('role', 'operator')->count();
        $activeMekaniks = User::where('role', 'mekanik')->count();
        
        // Default values for models that might not exist yet
        $pendingTasks = 0;
        $totalEquipment = 0;
        $equipmentStatus = [
            'idle' => 0,
            'operasi' => 0,
            'rusak' => 0,
            'servis' => 0,
        ];
        $taskSummary = [
            'todo' => 0,
            'doing' => 0,
            'done' => 0,
            'cancelled' => 0,
            'total' => 0,
        ];
        $maintenanceDue = collect();
        $reportSeverity = [
            'low' => 0,
            'medium' => 0,
            'high' => 0,
            'total' => 0,
        ];

        // Try to get data from models if they exist
        try {
            if (class_exists('App\Models\Task')) {
                $taskModel = app('App\Models\Task');
                $pendingTasks = $taskModel::whereIn('status', ['todo', 'doing'])->count();
                $taskSummary = [
                    'todo' => $taskModel::where('status', 'todo')->count(),
                    'doing' => $taskModel::where('status', 'doing')->count(),
                    'done' => $taskModel::where('status', 'done')->count(),
                    'cancelled' => $taskModel::where('status', 'cancelled')->count(),
                    'total' => $taskModel::count(),
                ];
            }
        } catch (\Exception $e) {
            // Model doesn't exist or table doesn't exist
        }

        try {
            if (class_exists('App\Models\Equipment')) {
                $equipmentModel = app('App\Models\Equipment');
                $totalEquipment = $equipmentModel::count();
                $equipmentStatus = [
                    'idle' => $equipmentModel::where('status', 'idle')->count(),
                    'operasi' => $equipmentModel::where('status', 'operasi')->count(),
                    'rusak' => $equipmentModel::where('status', 'rusak')->count(),
                    'servis' => $equipmentModel::where('status', 'servis')->count(),
                ];
            }
        } catch (\Exception $e) {
            // Model doesn't exist or table doesn't exist
        }

        try {
            if (class_exists('App\Models\Maintenance')) {
                $maintenanceModel = app('App\Models\Maintenance');
                $maintenanceDue = $maintenanceModel::where('next_service', '<=', now()->addDays(7))
                    ->with('equipment')
                    ->get();
            }
        } catch (\Exception $e) {
            // Model doesn't exist or table doesn't exist
        }

        try {
            if (class_exists('App\Models\Report')) {
                $reportModel = app('App\Models\Report');
                $reportSeverity = [
                    'low' => $reportModel::where('severity', 'low')->count(),
                    'medium' => $reportModel::where('severity', 'medium')->count(),
                    'high' => $reportModel::where('severity', 'high')->count(),
                    'total' => $reportModel::count(),
                ];
            }
        } catch (\Exception $e) {
            // Model doesn't exist or table doesn't exist
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeOperators',
            'activeMekaniks',
            'pendingTasks',
            'totalEquipment',
            'equipmentStatus',
            'taskSummary',
            'maintenanceDue',
            'reportSeverity'
        ));
    }
}
