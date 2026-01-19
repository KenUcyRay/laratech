<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenancesSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = Equipment::all();

        if ($equipments->isEmpty()) {
            return;
        }

        foreach ($equipments as $equipment) {
            Maintenance::create([
                'equipment_id' => $equipment->id,
                'schedule_type' => 'hour_based',
                'last_service' => now()->subMonths(1),
                'next_service' => now()->addMonths(1),
            ]);
        }
    }
}
