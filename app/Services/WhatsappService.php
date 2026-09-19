<?php

namespace App\Services;

use App\Repositories\Whatsapp\IWhatsappBridgeRepository;
use App\Repositories\Whatsapp\Models\Whatsapp;
use Illuminate\Support\Collection;

class WhatsappService
{
    public function __construct(
        protected IWhatsappBridgeRepository $whatsappRepo,
    ){}

    public function getAll():Collection
    {
        return $this->whatsappRepo->getAll();
    }
    public function messagesFor(string $phone):Collection
    {
        return $this->whatsappRepo->messagesFor($phone);
    }
    public function store(string $messageId,array $data):Whatsapp
    {
        return $this->whatsappRepo->store($messageId,$data);
    }
    public function normalizePhone(string $phone): string
    {
      return $this->whatsappRepo->normalizePhone($phone);
    }

}
