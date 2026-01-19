<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentsSeeder extends Seeder
{
    public function run(): void
    {
        $types = EquipmentType::all();

        if ($types->isEmpty()) {
            return;
        }

        foreach ($types as $type) {
            Equipment::create([
                'code' => strtoupper(Str::slug($type->name)) . '-' . rand(100, 999),
                'name' => $type->name . ' ' . rand(1, 10),
                'equipment_type_id' => $type->id,
                'status' => 'idle',
                'hour_meter' => rand(100, 5000),
            ]);

            Equipment::create([
                'code' => strtoupper(Str::slug($type->name)) . '-' . rand(100, 999),
                'name' => $type->name . ' ' . rand(11, 20),
                'equipment_type_id' => $type->id,
                'status' => 'operasi',
                'hour_meter' => rand(100, 5000),
            ]);
        }
    }
}
