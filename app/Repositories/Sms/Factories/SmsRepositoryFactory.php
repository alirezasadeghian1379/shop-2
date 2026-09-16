<?php

namespace App\Repositories\Sms\Factories;

use App\Repositories\Sms\Contracts\ISmsRepository;
use App\Repositories\Sms\Drivers\SmsIr;

class SmsRepositoryFactory
{
    public static function make(string $provider = null): ISmsRepository
    {
        $provider = $provider ?? config('sms.default');
        return match ($provider) {
            'smsIr' => app(SmsIr::class),
        };
    }
}
