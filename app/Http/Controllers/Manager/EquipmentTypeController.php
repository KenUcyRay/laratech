<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index()
    {
        $types = EquipmentType::withCount('equipments')->paginate(10);
        return view('manager.equipment_types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:equipment_types,name',
            'description' => 'nullable|string',
        ]);

        $type = EquipmentType::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tipe equipment berhasil ditambahkan',
            'data' => $type
        ]);
    }

    public function edit($id)
    {
        $type = EquipmentType::findOrFail($id);

        // Return JSON for modal population
        return response()->json([
            'status' => 'success',
            'data' => $type
        ]);
    }

    public function update(Request $request, $id)
    {
        $type = EquipmentType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:equipment_types,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $type->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tipe equipment berhasil diperbarui',
            'data' => $type
        ]);
    }

    public function destroy($id)
    {
        $type = EquipmentType::findOrFail($id);

        if ($type->equipments()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat menghapus tipe ini karena masih digunakan oleh equipment.'
            ], 400);
        }

        $type->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tipe equipment berhasil dihapus'
        ]);
    }
}
