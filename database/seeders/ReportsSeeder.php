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
        $reporters = User::whereIn('role', ['operator', 'mekanik'])->get();

        if ($equipments->isEmpty() || $reporters->isEmpty()) {
            return;
        }

        $descriptions = [
            'Engine making unusual noise during operation',
            'Hydraulic fluid leak detected',
            'Brake system not responding properly',
            'Excessive vibration when in use',
            'Electrical fault - lights not working',
            'Coolant temperature running high',
            'Track/tire damage observed',
            'Oil pressure warning light on',
            'Smoke from exhaust',
            'Control lever stuck',
        ];

        $severities = ['low', 'medium', 'high'];

        foreach ($equipments->take(15) as $equipment) {
            $numReports = rand(0, 2);

            for ($i = 0; $i < $numReports; $i++) {
                Report::create([
                    'equipment_id' => $equipment->id,
                    'user_id' => $reporters->random()->id,
                    'description' => $descriptions[array_rand($descriptions)] . ' on ' . $equipment->name,
                    'severity' => $severities[array_rand($severities)],
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}
