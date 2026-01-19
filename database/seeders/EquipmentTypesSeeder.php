<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Excavator', 'description' => 'Heavy construction equipment mainly used for digging.'],
            ['name' => 'Bulldozer', 'description' => 'Continuous tracked tractor equipped with a metal plate.'],
            ['name' => 'Dump Truck', 'description' => 'Truck used for transporting loose material.'],
            ['name' => 'Wheel Loader', 'description' => 'Heavy equipment machine used for moving aside or loading materials.'],
            ['name' => 'Crane', 'description' => 'Machine used to lift and move heavy objects.'],
            ['name' => 'Grader', 'description' => 'Construction machine used to create flat surfaces.'],
        ];

        foreach ($types as $type) {
            EquipmentType::create($type);
        }
    }
}
