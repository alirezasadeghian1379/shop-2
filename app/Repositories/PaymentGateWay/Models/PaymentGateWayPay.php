<?php

namespace App\Repositories\PaymentGateWay\Models;

class PaymentGateWayPay
{
    public ?string $url;
    public ?string $authority;
    public ?int $statusCode;
    public ?string $message;

    public function __construct(?string $url, ?string $authority,?int $statusCode, ?string $message)
    {
        $this->url = $url;
        $this->authority = $authority;
        $this->statusCode = $statusCode;
        $this->message = $message;
    }
}
