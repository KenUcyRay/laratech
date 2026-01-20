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

        $scheduleTypes = ['daily', 'weekly', 'monthly', 'hour_based', 'yearly'];

        foreach ($equipments as $index => $equipment) {
            $scheduleType = $scheduleTypes[$index % count($scheduleTypes)];

            $daysToNext = match ($scheduleType) {
                'daily' => rand(-2, 2),
                'weekly' => rand(-7, 7),
                'monthly' => rand(-30, 30),
                'yearly' => rand(-60, 90),
                'hour_based' => rand(-15, 45),
                default => 30,
            };

            Maintenance::create([
                'equipment_id' => $equipment->id,
                'schedule_type' => $scheduleType,
                'last_service' => now()->subDays(rand(10, 60)),
                'next_service' => now()->addDays($daysToNext),
            ]);
        }
    }
}
