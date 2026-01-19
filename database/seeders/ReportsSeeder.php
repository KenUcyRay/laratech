<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportsSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = Equipment::all();
        $operators = User::where('role', 'operator')->get();

        if ($equipments->isEmpty() || $operators->isEmpty()) {
            return;
        }

        foreach ($equipments as $equipment) {
            Report::create([
                'equipment_id' => $equipment->id,
                'user_id' => $operators->random()->id,
                'description' => 'Noise coming from engine in ' . $equipment->name,
                'severity' => 'medium',
            ]);
        }
    }
}
