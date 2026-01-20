<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        $maintenances = Maintenance::with(['equipment.type'])
            ->latest()
            ->get();

        return view('operator.maintenance.index', compact('maintenances'));
    }
}
