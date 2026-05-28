<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            ['name' => 'Big Blue', 'registration_plate' => 'GP 12 AB 12', 'type' => 'truck', 'make' => 'Mercedes-Benz', 'model' => 'Actros', 'year' => 2020, 'capacity_kg' => 10000, 'status' => 'available'],
            ['name' => 'Silver Sprinter', 'registration_plate' => 'GP 34 CD 34', 'type' => 'van', 'make' => 'Mercedes-Benz', 'model' => 'Sprinter', 'year' => 2021, 'capacity_kg' => 1500, 'status' => 'available'],
            ['name' => 'Flatbed King', 'registration_plate' => 'GP 56 EF 56', 'type' => 'flatbed', 'make' => 'Volvo', 'model' => 'FH', 'year' => 2019, 'capacity_kg' => 20000, 'status' => 'maintenance'],
        ];

        foreach ($vehicles as $v) {
            Vehicle::firstOrCreate(['registration_plate' => $v['registration_plate']], $v);
        }
    }
}
