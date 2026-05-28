<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            ['business_name' => 'Nobela Logistics', 'phone' => '+27 82 123 4567', 'address' => '120 Rietfontein Road, Germiston', 'status' => 'active', 'description' => 'Our primary in-house logistics division.'],
            ['business_name' => 'Steel Works SA', 'phone' => '+27 83 456 7890', 'address' => 'Boksburg Industrial Park', 'status' => 'active', 'description' => 'Specialists in steel fabrication and boilermaking.'],
        ];

        foreach ($vendors as $v) {
            Vendor::firstOrCreate(['business_name' => $v['business_name']], $v);
        }
    }
}
