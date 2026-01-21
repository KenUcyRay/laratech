<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        // (Inventory Tab)
        $allEquipments = Equipment::with('type')
            ->orderBy('code')
            ->paginate(10, ['*'], 'inventory_page');

        // (Monitoring Tab - Exclude Active Reports)
        $activeReportEquipmentIds = \App\Models\Report::whereIn('status', ['pending', 'processing'])
            ->pluck('equipment_id')
            ->toArray();

        $monitorEquipments = Equipment::with('type')
            ->whereNotIn('id', $activeReportEquipmentIds)
            ->orderBy('code')
            ->paginate(10, ['*'], 'monitoring_page');

        $equipments = Equipment::whereNotIn('id', $activeReportEquipmentIds)->orderBy('name')->get();

        return view('operator.equipment.index', compact('allEquipments', 'monitorEquipments', 'equipments'));
    }
}