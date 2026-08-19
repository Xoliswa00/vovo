<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $boilermaking = Category::where('name', 'Boilermaking & Fabrication')->first();
        $industrial   = Category::where('name', 'Industrial Services')->first();
        $logistics    = Category::where('name', 'Transport & Logistics')->first();

        $steelWorks = Vendor::where('business_name', 'Steel Works SA')->first();
        $nobelaLog  = Vendor::where('business_name', 'Nobela Logistics')->first();

        $services = [
            [
                'title'       => 'Boilermaking & Steel Fabrication',
                'description' => 'Custom steel fabrication, welding, and boilermaking — from trailer chassis to structural repairs, built in-house to your specifications.',
                'category_id' => $boilermaking?->id,
                'vendor_id'   => $steelWorks?->id,
                'status'      => true,
                'images'      => [
                    'assets/img/boilermaking-trailer-chassis-1.jpg',
                    'assets/img/boilermaking-trailer-chassis-2.jpg',
                    'assets/img/boilermaking-frame-weld.jpg',
                    'assets/img/boilermaking-axle-assembly.jpg',
                ],
            ],
            [
                'title'       => 'Freight & Logistics Delivery',
                'description' => 'Freight and parcel delivery across South Africa, with shipment tracking from pickup to drop-off.',
                'category_id' => $logistics?->id,
                'vendor_id'   => $nobelaLog?->id,
                'status'      => true,
                'images'      => [
                    'assets/img/hero-freight-highway.jpg',
                ],
            ],
            [
                'title'       => 'Site Welding & Structural Repairs',
                'description' => 'On-site welding and structural steel repairs for industrial and commercial properties.',
                'category_id' => $industrial?->id,
                'vendor_id'   => $steelWorks?->id,
                'status'      => true,
                'images'      => [],
            ],
        ];

        foreach ($services as $data) {
            $images = $data['images'];
            unset($data['images']);

            $service = Service::firstOrCreate(['title' => $data['title']], $data);

            if ($service->wasRecentlyCreated) {
                foreach ($images as $i => $path) {
                    $service->images()->create([
                        'image_path' => $path,
                        'is_primary' => $i === 0,
                    ]);
                }
            }
        }
    }
}
