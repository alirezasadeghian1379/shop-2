<?php

namespace App\Repositories\Sms\Models;

class Sms
{
    public string $status;
    public string $message;
    public ?string $resultCode;
    public array|int|null $messageIds;
    public ?int $cost;
    public function __construct(string $status, string $message,?string $resultCode,array|int|null $messageIds,?int $cost)
    {
        $this->status = $status;
        $this->message = $message;
        $this->resultCode = $resultCode;
        $this->messageIds = $messageIds;
        $this->cost = $cost;
    }
}
