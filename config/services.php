<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'monitoring' => [
        'enabled' => env('MONITORING_ENABLED', false),
        // Xquisite hub BASE url — jobs append /api/health-report and /ingest/logs.
        // A legacy MONITORING_URL that still carries the /api/health-report path
        // is normalised back to the base here so both jobs build correct URLs
        // whether or not the deployed .env has been updated.
        'url'     => rtrim((string) preg_replace('#/api/health-report/?$#', '', (string) env('MONITORING_URL')), '/') ?: null,
        'token'   => env('MONITORING_TOKEN'),
        'slug'    => env('MONITORING_SLUG', 'nobela'), // this instance's slug on the hub; drives the dedup fingerprint
    ],

];
