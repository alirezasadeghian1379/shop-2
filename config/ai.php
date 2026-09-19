<?php

return [

    'default' => 'openAi',

    'proxy' => env('AI_PROXY'),

    'openAi' => [
        'url' => 'https://api.openai.com/v1/responses',
        'key' => env('OPENAI_API_KEY',''),
        'model' => env('OPENAI_MODEL','gpt-5.6-terra'),
        'models' => [
            'gpt-5.6-luna',
            'gpt-5.6-terra',
            'gpt-5.6-sol',
        ]
    ],
    'openRouter' => [
        'url' => 'https://openrouter.ai/api/v1/chat/completions',
        'key' => env('OPEN_ROUTER_API_KEY'),
        'model' => env('OPEN_ROUTER_MODEL'),
    ],
    'grog' => [
        'url' => 'https://api.groq.com/openai/v1/chat/completions',
        'key' => env('GROG_API_KEY'),
        'model' => env('GROG_MODEL'),
    ],
    'bluesminds' => [
        'url' => 'https://api.bluesminds.com/v1/chat/completions',
        'key' => env('BLUESMINDS_API_KEY'),
        'models' => [
            'meta/llama-3.2-11b-vision-instruct',
        ],
        'model' => env('BLUESMINDS_MODEL','meta/llama-3.2-11b-vision-instruct'),
    ]

];
