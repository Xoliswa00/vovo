<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Structured, queryable capture of what the app logs. The flat
 * storage/logs/laravel.log file is still written by the `single` channel;
 * this table exists so the Xquisite error forwarder (nobela:report-errors)
 * has a watermarked source to ship error+ rows from.
 *
 * Deliberately level/channel/message only — no stack traces or context
 * arrays. Those can carry query fragments or tokens from exception
 * messages, and forwarded rows leave this server. `forwarded_at` is the
 * once-only watermark: NULL = not yet shipped to the hub.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('level', 20);
            $table->string('channel', 40)->nullable();
            $table->text('message');
            $table->timestamp('logged_at');
            $table->timestamp('forwarded_at')->nullable();

            $table->index(['level', 'logged_at']);
            $table->index(['forwarded_at', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
