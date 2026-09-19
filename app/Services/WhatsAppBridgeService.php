<?php

namespace App\Services;

use App\Repositories\WhatsappBridge\IWhatsappBridgeRepository;
use Illuminate\Http\Client\PendingRequest;

class WhatsAppBridgeService
{
    public function __construct(
        protected IWhatsappBridgeRepository $whatsappBridgeRepository
    ){}

    public function status(): array
    {
        return $this->whatsappBridgeRepository->status();
    }

    public function connect(): array
    {
        return $this->whatsappBridgeRepository->connect();
    }

    public function disconnect(): array
    {
        return $this->whatsappBridgeRepository->disconnect();
    }

    private function request(): PendingRequest
    {
       return $this->whatsappBridgeRepository->request();
    }
}
