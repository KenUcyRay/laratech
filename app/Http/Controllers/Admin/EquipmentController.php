<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentImage;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with(['type', 'images'])->latest()->get();
        // Load types for the Create/Edit modal/form
        $types = EquipmentType::all();

        return view('admin.equipment.index', compact('equipments', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:equipments,code',
            'name' => 'required|string',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'status' => 'required|in:idle,operasi,rusak,servis',
            'hour_meter' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $equipment = Equipment::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('equipment-images', 'public');
                EquipmentImage::create([
                    'equipment_id' => $equipment->id,
                    'image_url' => Storage::url($path),
                    'is_primary' => $index === 0 // First image is primary
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Equipment berhasil ditambahkan',
            'data' => $equipment
        ]);
    }

    public function show($id) // For viewing detail in modal or page
    {
        $equipment = Equipment::with(['type', 'images', 'tasks', 'maintenances', 'reports'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $equipment
        ]);
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:equipments,code,' . $id,
            'name' => 'required|string',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'status' => 'required|in:idle,operasi,rusak,servis',
            'hour_meter' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $equipment->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('equipment-images', 'public');
                EquipmentImage::create([
                    'equipment_id' => $equipment->id,
                    'image_url' => Storage::url($path),
                    'is_primary' => false
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Equipment berhasil diperbarui',
            'data' => $equipment->load('images')
        ]);
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        $equipment->delete(); // Soft delete

        return response()->json([
            'status' => 'success',
            'message' => 'Equipment berhasil dihapus'
        ]);
    }
}
