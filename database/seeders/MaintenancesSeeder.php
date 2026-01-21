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
        $assignees = \App\Models\User::where('role', 'mekanik')->get();

        if ($equipments->isEmpty() || $assignees->isEmpty()) {
            return;
        }

        foreach ($equipments as $equipment) {
            // Randomly determine if it has a last service
            $hasLastService = rand(0, 1);

            $lastServiceDate = $hasLastService ? now()->subDays(rand(10, 100)) : null;

            // Random interval (30, 60, 90 days)
            $intervalDays = rand(1, 3) * 30;

            $nextServiceDue = $lastServiceDate
                ? $lastServiceDate->copy()->addDays($intervalDays)
                : now()->addDays($intervalDays);

            Maintenance::create([
                'equipment_id' => $equipment->id,
                'user_id' => $assignees->random()->id,
                'last_service_date' => $lastServiceDate,
                'next_service_due' => $nextServiceDue,
                'interval_days' => $intervalDays,
            ]);
        }
    }
}
