<?php

namespace App\Repositories\WhatsappBridge;

use App\Repositories\Whatsapp\Models\Whatsapp;
use Illuminate\Support\Collection;
use Illuminate\Http\Client\PendingRequest;

interface IWhatsappBridgeRepository
{
    public function status(): array;
    public function connect(): array;
    public function disconnect(): array;
    public function request(): PendingRequest;
}
