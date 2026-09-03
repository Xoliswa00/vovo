<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sitemap:generate-dynamic')->daily();

// Xquisite monitoring heartbeat — sync, not queued, so a dead queue worker
// can't mask an outage (see App\Jobs\ReportHealthStatus).
Schedule::job(new \App\Jobs\ReportHealthStatus)->everyFiveMinutes();

// Xquisite error forwarding — ships error+ system_logs rows to the central
// hub so all apps' errors are visible in one place.
Schedule::command('nobela:report-errors')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/xquisite-forward.log'));
