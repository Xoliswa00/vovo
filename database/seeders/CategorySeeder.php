<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Transport & Logistics', 'type' => 'both', 'icon' => 'bi-truck'],
            ['name' => 'Heavy Equipment', 'type' => 'product', 'icon' => 'bi-gear'],
            ['name' => 'Construction Materials', 'type' => 'product', 'icon' => 'bi-building'],
            ['name' => 'Tools & Hardware', 'type' => 'product', 'icon' => 'bi-tools'],
            ['name' => 'Boilermaking & Fabrication', 'type' => 'service', 'icon' => 'bi-fire'],
            ['name' => 'Industrial Services', 'type' => 'service', 'icon' => 'bi-wrench'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], array_merge($cat, ['slug' => Str::slug($cat['name'])]));
        }
    }
}
