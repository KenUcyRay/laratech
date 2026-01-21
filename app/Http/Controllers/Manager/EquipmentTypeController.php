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

        EquipmentType::create($validated);

        return redirect()->route('manager.equipment-types.index')->with('success', 'Equipment type berhasil ditambahkan');
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

        return redirect()->route('manager.equipment-types.index')->with('success', 'Equipment type berhasil diperbarui');
    }

    public function destroy($id)
    {
        $type = EquipmentType::findOrFail($id);

        if ($type->equipments()->count() > 0) {
            return redirect()->route('manager.equipment-types.index')->with('error', 'Tidak dapat menghapus tipe ini karena masih digunakan oleh equipment.');
        }

        $type->delete();

        return redirect()->route('manager.equipment-types.index')->with('success', 'Equipment type berhasil dihapus');
    }
}
