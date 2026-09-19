<?php

namespace App\Repositories\Whatsapp;

use App\Repositories\Whatsapp\Models\Whatsapp;
use Illuminate\Support\Collection;

interface IWhatsappRepository
{
    public function getAll():Collection;
    public function messagesFor(string $phone):Collection;
    public function store(string $messageId,array $data):Whatsapp;
    public function normalizePhone(string $phone):string;

}
