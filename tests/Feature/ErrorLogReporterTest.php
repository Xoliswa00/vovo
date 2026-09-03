<?php

namespace Tests\Feature;

use App\Models\SystemLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * nobela:report-errors — forwards error+ system_logs rows to the Xquisite
 * monitoring hub (POST {MONITORING_URL}/ingest/logs).
 */
class ErrorLogReporterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.monitoring.enabled' => true,
            'services.monitoring.url'     => 'https://hub.test',
            'services.monitoring.token'   => 'test-token',
            'services.monitoring.slug'    => 'nobela',
        ]);
    }

    private function log(string $level, string $message, ?string $forwardedAt = null): SystemLog
    {
        return SystemLog::create([
            'level'        => $level,
            'channel'      => 'testing',
            'message'      => $message,
            'logged_at'    => now()->subMinutes(2),
            'forwarded_at' => $forwardedAt,
        ]);
    }

    public function test_it_forwards_error_rows_and_marks_them_sent(): void
    {
        Http::fake(['hub.test/*' => Http::response(['accepted' => 2, 'duplicates' => 0, 'instance' => 'nobela'], 200)]);

        $a = $this->log('error', 'RuntimeException: boom');
        $b = $this->log('critical', 'DB gone');
        $this->log('warning', 'just a warning');       // below threshold
        $this->log('error', 'already sent', now());    // has watermark

        $this->artisan('nobela:report-errors')->assertSuccessful();

        Http::assertSent(function ($request) use ($a, $b) {
            $body = $request->data();

            return $request->url() === 'https://hub.test/ingest/logs'
                && $request->hasHeader('Authorization', 'Bearer test-token')
                && count($body['events']) === 2
                && $body['events'][0]['fingerprint'] === "nobela-{$a->id}"
                && $body['events'][1]['fingerprint'] === "nobela-{$b->id}"
                && $body['events'][0]['level'] === 'error';
        });

        $this->assertNotNull($a->fresh()->forwarded_at);
        $this->assertNotNull($b->fresh()->forwarded_at);
    }

    public function test_a_non_2xx_response_does_not_advance_the_watermark(): void
    {
        Http::fake(['hub.test/*' => Http::response(['error' => 'Invalid token'], 401)]);

        $row = $this->log('error', 'boom');

        $this->artisan('nobela:report-errors')->assertSuccessful();

        $this->assertNull($row->fresh()->forwarded_at);
    }

    public function test_backfill_marks_without_sending(): void
    {
        Http::fake();

        $this->log('error', 'old error one');
        $this->log('error', 'old error two');

        $this->artisan('nobela:report-errors', ['--backfill' => true])->assertSuccessful();

        Http::assertNothingSent();
        $this->assertSame(0, SystemLog::forwardable()->count());
    }

    public function test_it_is_a_noop_when_monitoring_is_disabled(): void
    {
        config(['services.monitoring.enabled' => false]);
        Http::fake();

        $this->log('error', 'boom');

        $this->artisan('nobela:report-errors')->assertSuccessful();

        Http::assertNothingSent();
    }

    public function test_it_scrubs_pii_from_the_message(): void
    {
        Http::fake(['hub.test/*' => Http::response(['accepted' => 1, 'duplicates' => 0], 200)]);

        $this->log('error', 'Login failed for jane.doe@example.com id 1234567890123');

        $this->artisan('nobela:report-errors')->assertSuccessful();

        Http::assertSent(function ($request) {
            $msg = $request->data()['events'][0]['message'];

            return ! str_contains($msg, 'jane.doe@example.com')
                && ! str_contains($msg, '1234567890123')
                && str_contains($msg, '«redacted-email»');
        });
    }

    public function test_the_database_log_channel_captures_error_rows(): void
    {
        \Illuminate\Support\Facades\Log::error('captured by the database channel');

        $this->assertSame(1, SystemLog::where('level', 'error')
            ->where('message', 'captured by the database channel')
            ->count());
    }

    public function test_monitoring_verify_passes(): void
    {
        $this->artisan('monitoring:verify')->assertSuccessful();
    }
}
