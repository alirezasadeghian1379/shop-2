<?php

namespace App\Repositories\WhatsappBridge;

use App\Helpers\Adapters\Exception\Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class WhatsappBridgeModuleRepository implements IWhatsappBridgeRepository
{
    public function status(): array
    {
        return $this->request()->get('/whatsapp/status')->throw()->json();
    }

    public function connect(): array
    {
        return $this->request()->post('/whatsapp/connect')->throw()->json();
    }

    public function disconnect(): array
    {
        return $this->request()->post('/whatsapp/disconnect')->throw()->json();
    }

    public function request(): PendingRequest
    {
        $url = rtrim((string) config('messenger.whatsapp.bridge.url'), '/');
        $token = (string) config('messenger.whatsapp.bridge.token');

        if ($url === '' || $token === '') {
            throw new Exception('تنظیمات WhatsApp Bridge کامل نشده است.',422);
        }

        return Http::baseUrl($url)
            ->acceptJson()
            ->withToken($token)
            ->connectTimeout(3)
            ->timeout(10);
    }
}
