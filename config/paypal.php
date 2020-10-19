<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode' => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
        'username' => env('PAYPAL_SANDBOX_API_USERNAME'),
        'password' => env('PAYPAL_SANDBOX_API_PASSWORD'),
        'secret' => env('PAYPAL_SANDBOX_API_SECRET'),
        'certificate' => env('PAYPAL_SANDBOX_API_CERTIFICATE', null),
        'app_id' => env('PAYPAL_SANDBOX_APP_ID', null),
    ],
    'live' => [
        'username' => env('PAYPAL_LIVE_API_USERNAME'),
        'password' => env('PAYPAL_LIVE_API_PASSWORD'),
        'secret' => env('PAYPAL_LIVE_API_SECRET'),
        'certificate' => env('PAYPAL_LIVE_API_CERTIFICATE', null),
        'app_id' => env('PAYPAL_LIVE_APP_ID', null),
    ],
    'payment_action' => 'sale',
    'currency' => env('PAYPAL_CURRENCY', 'USD'),
    'billing_type' => 'MerchantInitiatedBilling',
    'notify_url' => 'http://ladyrecord.com/ordenes/paypal/webhook',
    'locale' => 'es_ES',
    'validate_ssl' => true,
];
