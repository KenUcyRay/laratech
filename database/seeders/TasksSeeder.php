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
        $mechanics = User::where('role', 'mechanic')->get();
        $operators = User::where('role', 'operator')->get();

        if ($equipments->isEmpty() || ($mechanics->isEmpty() && $operators->isEmpty())) {
            return;
        }

        foreach ($equipments as $equipment) {
            Task::create([
                'equipment_id' => $equipment->id,
                'assigned_to' => $mechanics->random()->id ?? $operators->random()->id,
                'title' => 'Routine Check for ' . $equipment->name,
                'status' => 'todo',
                'priority' => 'medium',
                'due_date' => now()->addDays(3),
            ]);
        }
    }
}
