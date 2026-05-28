<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@nobelaenterprises.co.za',
        ]);

        $this->call([
            CategorySeeder::class,
            VendorSeeder::class,
            VehicleSeeder::class,
            ServicesSeeder::class,
        ]);
    }
}
