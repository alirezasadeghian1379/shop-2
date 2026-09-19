<?php

namespace App\Repositories\Messenger\Factories;

use App\Repositories\Messenger\Api\WhatsappApiRepository;
use App\Repositories\Messenger\Contracts\IMessengerRepository;

class MessengerFactoryRepository
{
    public static function make(string $provider = null): IMessengerRepository
    {
        $provider = $provider ?? config('messenger.default');
        return match ($provider) {
            'whatsapp' => app(WhatsappApiRepository::class),
        };
    }
}
