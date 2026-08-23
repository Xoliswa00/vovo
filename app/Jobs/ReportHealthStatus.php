<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportHealthStatus
{
    use Dispatchable;

    /**
     * Send a heartbeat to Xquisite so it can alert if this site stops checking in.
     *
     * Deliberately does NOT implement ShouldQueue — a heartbeat that depends on a
     * queue worker being alive can't tell you the worker itself died. The
     * scheduler (routes/console.php) runs this synchronously every 5 minutes.
     *
     * TODO: the endpoint path and payload keys below are a placeholder, not a
     * confirmed contract — update them once the instance is created in Xquisite
     * and its actual heartbeat API spec (path/auth/payload) is known.
     */
    public function handle(): void
    {
        if (! config('services.monitoring.enabled')) {
            return;
        }

        $url = config('services.monitoring.url');
        $token = config('services.monitoring.token');

        if (! $url || ! $token) {
            Log::warning('Health status reporting is enabled but MONITORING_URL or MONITORING_TOKEN is missing.');

            return;
        }

        try {
            Http::withToken($token)
                ->timeout(5)
                ->post(rtrim($url, '/').'/heartbeat', [
                    'project'    => config('app.name'),
                    'status'     => 'ok',
                    'checked_at' => now()->toIso8601String(),
                ]);
        } catch (\Throwable $e) {
            Log::warning('Health status heartbeat failed to send: '.$e->getMessage());
        }
    }
}
