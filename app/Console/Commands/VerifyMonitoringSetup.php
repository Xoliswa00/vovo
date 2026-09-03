<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Checks the Xquisite monitoring integration is still wired up — the
 * heartbeat job, the health route, the JS error beacon, and the server-side
 * error forwarder (nobela:report-errors) with its schedule entry. Run via
 * `php artisan monitoring:verify`. Registering the instance + token on the
 * hub is a separate manual step — this only checks the code is here.
 */
class VerifyMonitoringSetup extends Command
{
    protected $signature = 'monitoring:verify';

    protected $description = 'Check the Xquisite monitoring integration (heartbeat, forwarder, health route, JS beacon) is still present';

    public function handle(): int
    {
        $problems = [];

        if (! file_exists(app_path('Jobs/ReportHealthStatus.php'))) {
            $problems[] = 'app/Jobs/ReportHealthStatus.php is missing — the 5-minute heartbeat job.';
        }

        if (! file_exists(app_path('Console/Commands/ReportErrorsToXquisite.php'))) {
            $problems[] = 'app/Console/Commands/ReportErrorsToXquisite.php is missing — the error forwarder (nobela:report-errors).';
        }

        if (! file_exists(app_path('Logging/DatabaseLogHandler.php'))) {
            $problems[] = 'app/Logging/DatabaseLogHandler.php is missing — nothing captures error+ into system_logs to forward.';
        }

        $beaconPath = resource_path('views/partials/monitoring-beacon.blade.php');
        if (! file_exists($beaconPath)) {
            $problems[] = 'resources/views/partials/monitoring-beacon.blade.php is missing — the JS error beacon.';
        } elseif (! $this->includedInAnyView('partials.monitoring-beacon')) {
            $problems[] = "monitoring-beacon.blade.php exists but isn't @include'd in any view — it'll never run.";
        }

        $logging = file_get_contents(config_path('logging.php'));
        if (! str_contains($logging, 'DatabaseLogHandler')) {
            $problems[] = "config/logging.php no longer wires the 'database' channel to DatabaseLogHandler.";
        }

        $services = file_get_contents(config_path('services.php'));
        if (! str_contains($services, "'monitoring'")) {
            $problems[] = "config/services.php is missing the 'monitoring' block.";
        } else {
            foreach (['MONITORING_ENABLED', 'MONITORING_URL', 'MONITORING_TOKEN', 'MONITORING_SLUG'] as $var) {
                if (! str_contains($services, $var)) {
                    $problems[] = "config/services.php 'monitoring' block no longer reads {$var}.";
                }
            }
        }

        $envExample = base_path('.env.example');
        if (is_file($envExample)) {
            foreach (['MONITORING_ENABLED', 'MONITORING_URL', 'MONITORING_TOKEN', 'MONITORING_SLUG'] as $var) {
                if (! str_contains(file_get_contents($envExample), $var)) {
                    $problems[] = ".env.example is missing {$var}.";
                }
            }
        }

        $schedule = file_exists(base_path('routes/console.php')) ? file_get_contents(base_path('routes/console.php')) : '';
        if (! str_contains($schedule, 'ReportHealthStatus')) {
            $problems[] = 'ReportHealthStatus is never scheduled in routes/console.php.';
        }
        if (! str_contains($schedule, 'nobela:report-errors')) {
            $problems[] = 'nobela:report-errors is never scheduled — the error forwarder will never run.';
        }

        $web = file_exists(base_path('routes/web.php')) ? file_get_contents(base_path('routes/web.php')) : '';
        if (! str_contains($web, "'/api/health'") && ! str_contains($web, '/api/health')) {
            $problems[] = "No '/api/health' route — the hub's pull check has nothing to poll.";
        }

        if ($problems === []) {
            $this->info('OK — Xquisite monitoring integration is intact.');

            return self::SUCCESS;
        }

        $this->newLine();
        $this->error('Xquisite monitoring integration is broken:');
        foreach ($problems as $p) {
            $this->line("  - {$p}");
        }
        $this->newLine();
        $this->warn('If this was deliberate, update app/Console/Commands/VerifyMonitoringSetup.php');
        $this->warn('and check whether the instance needs re-registering on the Xquisite hub.');

        return self::FAILURE;
    }

    private function includedInAnyView(string $needle): bool
    {
        $dir = resource_path('views');
        if (! is_dir($dir)) {
            return false;
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        foreach ($iterator as $file) {
            if ($file->isFile()
                && str_ends_with($file->getFilename(), '.blade.php')
                && str_contains(file_get_contents($file->getPathname()), $needle)) {
                return true;
            }
        }

        return false;
    }
}
