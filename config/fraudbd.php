<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fraud.bd API Credentials
    |--------------------------------------------------------------------------
    |
    | Here you can configure your API keys for the Fraud.bd integration.
    | You can get these keys from your merchant dashboard.
    |
    */

    'api_key'    => env('FRAUDBD_API_KEY', ''),
    'secret_key' => env('FRAUDBD_SECRET_KEY', ''),
    'base_url'   => env('FRAUDBD_BASE_URL', 'https://fraud.bd/api/v1'),
];