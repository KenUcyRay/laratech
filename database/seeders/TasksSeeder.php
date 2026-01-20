<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = Equipment::all();
        $operators = User::where('role', 'operator')->get();
        $mekaniks = User::where('role', 'mekanik')->get();

        if ($equipments->isEmpty() || ($operators->isEmpty() && $mekaniks->isEmpty())) {
            return;
        }

        $allWorkers = $operators->merge($mekaniks);
        $taskTitles = [
            'Routine Inspection',
            'Oil Change',
            'Hydraulic System Check',
            'Track Maintenance',
            'Engine Diagnostics',
            'Electrical System Test',
            'Brake System Check',
            'Filter Replacement',
            'Coolant System Flush',
            'Tire Inspection',
        ];

        $statuses = ['todo', 'doing', 'done', 'cancelled'];
        $priorities = ['low', 'medium', 'high'];

        foreach ($equipments as $index => $equipment) {
            $numTasks = rand(1, 3);

            for ($i = 0; $i < $numTasks; $i++) {
                $status = $statuses[array_rand($statuses)];
                $task = [
                    'equipment_id' => $equipment->id,
                    'assigned_to' => $allWorkers->random()->id,
                    'title' => $taskTitles[array_rand($taskTitles)] . ' - ' . $equipment->name,
                    'status' => $status,
                    'priority' => $priorities[array_rand($priorities)],
                    'due_date' => now()->addDays(rand(-5, 10)),
                ];

                if ($status === 'doing') {
                    $task['started_at'] = now()->subHours(rand(1, 8));
                } elseif ($status === 'done') {
                    $task['started_at'] = now()->subDays(rand(1, 7));
                    $task['completed_at'] = now()->subDays(rand(0, 6));
                } elseif ($status === 'cancelled') {
                    $task['cancelled_at'] = now()->subDays(rand(0, 3));
                }

                Task::create($task);
            }
        }
    }
}
