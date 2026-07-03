<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Service;
use App\Models\Product;

class GenerateDynamicSitemap extends Command
{
    protected $signature = 'sitemap:generate-dynamic';
    protected $description = 'Generate the public sitemap, including active services and products';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create()
            ->add(Url::create(route('welcome'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create(route('about'))->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create(route('services.public'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('marketplace.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('quote.create'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        Service::where('status', true)->each(function (Service $service) use ($sitemap) {
            $sitemap->add(Url::create(route('services.show.public', $service))
                ->setLastModificationDate($service->updated_at)
                ->setPriority(0.8));
        });

        Product::where('status', 'active')->each(function (Product $product) use ($sitemap) {
            $sitemap->add(Url::create(route('marketplace.show', $product))
                ->setLastModificationDate($product->updated_at)
                ->setPriority(0.8));
        });

        $sitemapPath = public_path('sitemap.xml');
        $sitemap->writeToFile($sitemapPath);

        $this->info("Sitemap generated at: {$sitemapPath}");
    }
}
