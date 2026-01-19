<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentsSeeder extends Seeder
{
    public function run(): void
    {
        $types = EquipmentType::all();

        if ($types->isEmpty()) {
            return;
        }

        $statuses = ['idle', 'operasi', 'servis', 'rusak'];
        $counter = 1;

        foreach ($types as $type) {
            for ($i = 1; $i <= 4; $i++) {
                Equipment::create([
                    'code' => strtoupper(substr($type->name, 0, 3)) . '-' . str_pad($counter, 3, '0', STR_PAD_LEFT),
                    'name' => $type->name . ' Unit ' . $i,
                    'equipment_type_id' => $type->id,
                    'status' => $statuses[($i - 1) % 4],
                    'hour_meter' => rand(500, 10000),
                ]);
                $counter++;
            }
        }
    }
}
