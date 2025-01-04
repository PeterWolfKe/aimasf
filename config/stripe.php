<?php

return [
    'secret_key' => env('STRIPE_SECRET_KEY'),
    'public_key' => env('STRIPE_PUBLIC_KEY'),
    'webhook_key' => env('STRIPE_WEBHOOK_KEY'),
];
