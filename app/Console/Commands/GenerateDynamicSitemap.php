<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Property;
use App\Models\Services;
use Illuminate\Support\Facades\Route;

class GenerateDynamicSitemap extends Command
{
    protected $signature = 'sitemap:generate-dynamic';
    protected $description = 'Generate a dynamic sitemap for the entire site';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // 1️⃣ Add static routes automatically
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return in_array('GET', $route->methods()) &&
                   $route->getName() &&
                   !str_contains($route->getName(), 'api');
        });

        foreach ($routes as $route) {
            $url = url($route->uri());
            $sitemap->add(Url::create($url)->setPriority(0.7));
        }

        // 2️⃣ Add dynamic properties
        Property::all()->each(function ($property) use ($sitemap) {
            $sitemap->add(Url::create(route('property.show', $property->id))
                ->setLastModificationDate($property->updated_at)
                ->setPriority(0.9));
        });

        // 3️⃣ Add dynamic services
        Services::all()->each(function ($service) use ($sitemap) {
            $sitemap->add(Url::create(route('services.show', $service->id))
                ->setLastModificationDate($service->updated_at)
                ->setPriority(0.9));
        });

        // 4️⃣ Save sitemap
        $sitemapPath = public_path('sitemap.xml');
        $sitemap->writeToFile($sitemapPath);

        $this->info("Sitemap generated at: {$sitemapPath}");
    }
}
