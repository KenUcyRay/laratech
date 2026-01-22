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

        foreach ($equipments as $index => $equipment) {
            // 70% On Schedule, 20% Due Soon, 10% Overdue
            $rand = rand(1, 100);

            if ($rand <= 10) {
                $statusType = 0; // Overdue
            } elseif ($rand <= 30) {
                $statusType = 1; // Due Soon
            } else {
                $statusType = 2; // On Schedule
            }

            // Random interval (30, 60, 90 days)
            $intervalDays = rand(1, 3) * 30;

            $nextServiceDue = null;

            if ($statusType === 0) {
                // Overdue: Due date was in the past (1 to 20 days ago)
                $nextServiceDue = now()->subDays(rand(1, 20));
            } elseif ($statusType === 1) {
                // Due Soon: Due date is within the next 2 days (e.g., 2 hours to 47 hours from now)
                $nextServiceDue = now()->addHours(rand(2, 47));
            } else {
                // On Schedule: Due date is safely in the future (3 to 60 days)
                $nextServiceDue = now()->addDays(rand(3, 60));
            }

            // Calculate last service date based on next service due
            // Last service = Next service - Interval
            // However, verify if this makes last service too far in the past or future.
            // It's safer to just say last service was exactly 'interval' days before 'next'
            $lastServiceDate = $nextServiceDue->copy()->subDays($intervalDays);

            // Sometimes (10% chance) make last_service_date null (never serviced before, but due)
            if (rand(1, 100) <= 10) {
                $lastServiceDate = null;
                // If never serviced, next_service_due is usually based on created_at or just set manually.
                // We keep nextServiceDue as is.
            }

            Maintenance::create([
                'equipment_id' => $equipment->id,
                'user_id' => $assignees->random()->id,
                'last_service_date' => $lastServiceDate,
                'next_service_due' => $nextServiceDue, // Based on our status logic
                'interval_days' => $intervalDays,
            ]);
        }
    }
}
