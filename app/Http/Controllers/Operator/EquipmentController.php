<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('type')->get();
        return view('operator.equipment.index', compact('equipments'));
    }
}