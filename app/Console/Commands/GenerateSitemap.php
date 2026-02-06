<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml with all public pages, tenant landings, and vehicles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(Url::create('/')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1.0));

        $sitemap->add(Url::create('/nosotros')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8));

        $sitemap->add(Url::create('/precios')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.9));

        // Legal pages
        $sitemap->add(Url::create('/terminos')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.3));

        $sitemap->add(Url::create('/privacidad')
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.3));

        // Tenant public landing pages
        $this->info('Adding tenant landing pages...');
        Tenant::with('domains')->each(function (Tenant $tenant) use ($sitemap) {
            $domain = $tenant->domains->first();
            if ($domain) {
                $sitemap->add(Url::create("/agencia/{$domain->domain}")
                    ->setLastModificationDate($tenant->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7));
            }
        });

        // Published vehicles (grouped by tenant)
        $this->info('Adding published vehicles...');
        $publishedCount = 0;
        
        Tenant::with(['domains', 'vehicles' => function ($query) {
            $query->where('estado', 'disponible')
                  ->where('visible', true)
                  ->orderBy('updated_at', 'desc');
        }])->each(function (Tenant $tenant) use ($sitemap, &$publishedCount) {
            $domain = $tenant->domains->first();
            
            if ($domain) {
                foreach ($tenant->vehicles as $vehicle) {
                    $sitemap->add(Url::create("/agencia/{$domain->domain}/vehiculo/{$vehicle->id}")
                        ->setLastModificationDate($vehicle->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.6));
                    
                    $publishedCount++;
                }
            }
        });

        // Write sitemap to public directory
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info("✓ Sitemap generated successfully!");
        $this->info("  - Tenant pages: " . Tenant::count());
        $this->info("  - Published vehicles: {$publishedCount}");
        $this->info("  - Total URLs: " . (5 + Tenant::count() + $publishedCount));

        return Command::SUCCESS;
    }
}
