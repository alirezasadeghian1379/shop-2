<?php

return [

    'default' => 'smsIr',

    'drivers' => [

        'smsIr' => [
            'api_key' => env('SMS_IR_API_KEY',null),
            'line_number' => env('SMS_IR_LINE_NUMBER',null),
            'user_name' => env('SMS_IR_USERNAME',null),
            'urls' => [
               'group' => 'https://api.sms.ir/v1/send/bulk',
               'verify' => 'https://api.sms.ir/v1/send/verify',
               'api' => 'https://api.sms.ir/v1/send',
            ]
        ],

    ]
];
