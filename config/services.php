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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // HNB CyberSource Payment Gateway
    'cybersource' => [
        'env'           => env('CYBERSOURCE_ENV', 'test'),
        'merchant_id'   => env('CYBERSOURCE_MERCHANT_ID'),
        'key_id'        => env('CYBERSOURCE_REST_KEY_ID'),
        'shared_secret' => env('CYBERSOURCE_SHARED_SECRET'),
        'currency'      => env('CYBERSOURCE_CURRENCY', 'USD'),
        // Resolved here (not via env() in application code) so this stays correct
        // even when config is cached (php artisan config:cache) — env() calls
        // outside config/*.php files return null once the config cache exists.
        // InitiatePaymentSessionAction uses this to fail loudly if CYBERSOURCE_ENV
        // is production but CYBERSOURCE_CURRENCY was never explicitly set, instead
        // of silently sending real transactions in the 'USD' default above (a real
        // wrong-currency risk confirmed in a TEST-environment log this session).
        'currency_explicit' => env('CYBERSOURCE_CURRENCY') !== null,
        // Online payment service charge, applied on top of the invoice amount.
        'service_fee_percentage' => env('CYBERSOURCE_SERVICE_FEE_PERCENTAGE', 3),
    ],

];
