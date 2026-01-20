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
        $assignees = \App\Models\User::whereIn('role', ['mekanik', 'operator'])->get();

        if ($equipments->isEmpty() || $assignees->isEmpty()) {
            return;
        }

        foreach ($equipments as $equipment) {
            // Randomly determine if it has a last service
            $hasLastService = rand(0, 1);

            $lastServiceDate = $hasLastService ? now()->subHours(rand(100, 1000)) : null;
            // 1500 jam = 62.5 hari.
            $nextServiceDue = $lastServiceDate ? $lastServiceDate->copy()->addHours(1500) : now()->addHours(1500);

            Maintenance::create([
                'equipment_id' => $equipment->id,
                'user_id' => $assignees->random()->id,
                'last_service_date' => $lastServiceDate,
                'next_service_due' => $nextServiceDue,
            ]);
        }
    }
}
