<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $heavyEquipment = Category::where('name', 'Heavy Equipment')->first();
        $materials      = Category::where('name', 'Construction Materials')->first();
        $tools          = Category::where('name', 'Tools & Hardware')->first();

        $steelWorks = Vendor::where('business_name', 'Steel Works SA')->first();

        $products = [
            [
                'title'       => 'Hydraulic Excavator — Mid-Size',
                'description' => 'Reliable mid-size hydraulic excavator, serviced and ready for site work.',
                'price'       => 850000.00,
                'stock'       => 2,
                'category_id' => $heavyEquipment?->id,
                'vendor_id'   => $steelWorks?->id,
                'status'      => 'active',
                'image'       => 'assets/img/products/excavator.jpg',
            ],
            [
                'title'       => 'Diesel Forklift — 3 Ton',
                'description' => 'Heavy-duty 3-ton diesel forklift, suited for warehouse and yard use.',
                'price'       => 320000.00,
                'stock'       => 3,
                'category_id' => $heavyEquipment?->id,
                'vendor_id'   => $steelWorks?->id,
                'status'      => 'active',
                'image'       => 'assets/img/products/forklift.jpg',
            ],
            [
                'title'       => 'Portland Cement — 50kg Bag',
                'description' => 'General purpose Portland cement, sold per 50kg bag.',
                'price'       => 95.00,
                'stock'       => 500,
                'category_id' => $materials?->id,
                'vendor_id'   => null,
                'status'      => 'active',
                'image'       => 'assets/img/products/cement-warehouse.jpg',
            ],
            [
                'title'       => 'Rapid-Set Cement — 25kg Bag',
                'description' => 'Fast-setting cement for smaller repair and finishing jobs, 25kg bag.',
                'price'       => 110.00,
                'stock'       => 300,
                'category_id' => $materials?->id,
                'vendor_id'   => null,
                'status'      => 'active',
                'image'       => 'assets/img/products/cement-sacks.jpg',
            ],
            [
                'title'       => 'Industrial Tool Kit — 45 Piece',
                'description' => 'General-purpose 45-piece tool kit for site and workshop use.',
                'price'       => 1450.00,
                'stock'       => 40,
                'category_id' => $tools?->id,
                'vendor_id'   => null,
                'status'      => 'active',
                'image'       => 'assets/img/products/hand-tools.jpg',
            ],
            [
                'title'       => 'Angle Grinder & Workshop Tool Set',
                'description' => 'Angle grinder and hand-tool bundle for fabrication and workshop tasks.',
                'price'       => 2200.00,
                'stock'       => 25,
                'category_id' => $tools?->id,
                'vendor_id'   => null,
                'status'      => 'active',
                'image'       => 'assets/img/products/workshop-tools.jpg',
            ],
        ];

        foreach ($products as $data) {
            $imagePath = $data['image'];
            unset($data['image']);

            $product = Product::firstOrCreate(['title' => $data['title']], $data);

            if ($product->wasRecentlyCreated) {
                $product->images()->create(['image_path' => $imagePath]);
            }
        }
    }
}
