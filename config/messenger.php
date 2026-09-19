<?php

return [
    'default' => 'whatsapp',

    'whatsapp' => [
        'api_key' => env('WHATSAPP_API_KEY'),
        'webhook_secret_key' => env('WEBHOOK_SECRET_KEY'),
        'urls' => [
            'sendMessage' => 'https://api.360messenger.com/v2/sendMessage',
            'setWebhook' => 'https://api.360messenger.com/v2/settings/webhook/set'
        ],
        'bridge' => [
            'url' => env('WHATSAPP_BRIDGE_URL', 'http://127.0.0.1:62162'),
            'token' => env('WHATSAPP_BRIDGE_TOKEN'),
        ],
        'conversation' => [
            'max_messages' => env('WHATSAPP_MEMORY_MESSAGES', 4),
            'ttl_minutes' => env('WHATSAPP_MEMORY_TTL', 1440),
        ],
    ]
];
